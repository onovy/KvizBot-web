# AGENTS.md

Guidance for AI coding agents working on this repository.

## Project overview

**KvizBot-web** is the web front-end for **XKvíz** — a Czech-language IRC trivia quiz game. It is a classic server-side PHP application backed by MySQL. There is no JavaScript framework, no Node.js, and no build toolchain.

- UI language: Czech (`cs_CZ.UTF-8`)
- Code comments: Czech
- License: GPL

## Tech stack

| Component | Technology |
|-----------|------------|
| Language | PHP 7.3+ (uses `PASSWORD_ARGON2ID`, null-coalescing operators, `random_bytes()`) |
| Database | MySQL/MariaDB via `mysqli` extension |
| Templates | [Smarty](https://smarty.php.net/) (vendored in `onovyPHPlib/extlib/Smarty/`) |
| Caching | Disk-based (`cache/`) + APCu for password verification |
| Graphs | `rrdtool` invoked via shell commands |

## Repository layout

```
index.php                   # Front-controller: routes ?page=X to modules/X.php
db_init.php                 # DB schema manager (check / create / repair tables)
configs/
  local.php-example         # Template for the required (gitignored) local.php
  local.php                 # DEPLOYMENT SECRET — never commit; holds DB credentials
  lib.php                   # Charset, locale, active module list
  templates.conf            # Smarty: site title, description, keywords
modules/                    # One PHP file per page/route (17 modules)
templates/                  # Smarty .tpl templates; module templates named mod_<name>.tpl
libs/                       # Web-level PHP libraries loaded on every request
  auth.php                  # Custom HTTP Basic Auth against the nicks table
  rpanel.php                # Right-panel score cache logic
onovyPHPlib/                # Embedded reusable PHP framework library
  init.php                  # Bootstrap step 1: loads config files, defines WEB_DIR/WEB_WWW
  main.php                  # Bootstrap step 2: loads libs, modules, and web libs
  lib/                      # Core library (sql, smarty, input, csrf, error, header, strings)
  mlib/                     # Optional modules (cache, ot2html, typo, ip, gentime, …)
  extlib/Smarty/            # Vendored Smarty engine
graph/
  graph.php                 # Updates online.rrd and generates PNG graphs
  graph_score.php           # Updates per-user score RRD files
  graph.sh                  # Cron wrapper: calls both graph PHP scripts
  graph-create.sh           # One-time: creates the online.rrd file
cache/                      # Disk cache (gitignored content)
templates_c/                # Smarty compiled template cache (gitignored)
rrd/                        # RRD databases and generated graph PNGs (gitignored content)
```

## Local setup

There is no build step and no package manager. Setup is manual:

1. **Configure** — copy `configs/local.php-example` to `configs/local.php` and fill in:
   - `web_dir` — absolute filesystem path to the web root
   - `web_www` — public base URL
   - MySQL credentials: `sql_name`, `sql_user`, `sql_pass`, `sql_host`
   - `compile_check`, `use_cache`, `verbose`, `error_reporting`

2. **Directory permissions** — the web server process must be able to write to:
   - `templates_c/`
   - `cache/`

3. **Initialize the database** — visit `db_init.php` in a browser (or run via CLI). Then call it again with `?really=1` to actually create/alter tables.

4. **Create RRD databases** — run `graph/graph-create.sh` once (requires setting a past start timestamp).

5. **Schedule cron** — add `graph/graph.sh` to cron to keep RRD graphs updated.

## Running

Serve the directory with Nginx + PHP-FPM. Clean URLs like `skore.htm` rewrite to `index.php?page=skore` — this must be configured in the nginx server block.

## No build step; no test suite

- There is no `Makefile`, `composer.json`, `package.json`, or any build toolchain.
- There is no automated test suite (no PHPUnit, no CI configuration).
- There is no linter or static analysis configuration.

Do not attempt to run `composer install`, `npm install`, or similar commands — they will fail or are irrelevant.

## Code conventions

**Style**
- Procedural PHP throughout — no classes, no namespaces.
- Indentation: **tabs**.
- Global variables are used extensively (`global $smarty`, `global $db_link`, `global $auth`).
- Comments are written in **Czech**.

**Input handling**
Always use the `input_*()` helper family for all user input — never access `$_GET`/`$_POST`/`$_COOKIE` directly without sanitization:
- `input_num()` — numeric input
- `input_string()` — string input (calls `db_escape_string()` internally)
- `input_array()` — array input

**Database**
- All queries go through `db_query()` / `db_fquery()` (defined in `onovyPHPlib/lib/sql.php`).
- SQL is hand-written using `sprintf`-style formatting — no ORM, no PDO prepared statements.
- String values must be escaped via `db_escape_string()` before interpolation.

**Templates**
- Smarty `.tpl` files live in `templates/`.
- Module templates follow the naming convention `mod_<name>.tpl`.
- A module assigns its template with `$smarty->assign('main', '<name>')`.

**Modules**
- Each page is a single file in `modules/`.
- The `mlib/` modules guard against direct access with `if (!defined('ONOVY_PHP_LIB')) die;` at the top — always include this guard in new mlib files.

## Security practices

Do not bypass these security mechanisms:

| Concern | Mechanism |
|---------|-----------|
| CSRF | Call `csrf_verify()` before every state-mutating POST |
| User input | Always use `input_*()` helpers; never use raw `$_POST`/`$_GET` |
| Shell commands | Wrap all arguments with `escapeshellarg()` |
| Regex from user input | Use `preg_quote()` to prevent ReDoS |
| Password hashing | `PASSWORD_ARGON2ID` via `password_hash()` / `password_verify()` |
| Token generation | `random_bytes()` — never `rand()` or `mt_rand()` |
| Cookie flags | Set `HttpOnly`, `Secure`, `SameSite=Strict` on all cookies |
| Direct PHP access | `die` guard in `mlib/` files; nginx must deny access to `libs/` |

## Database tables

| Table | Purpose |
|-------|---------|
| `nicks` | Registered users — nick, hashed password, score, timestamps, blocked flag |
| `perm` | User permission assignments (nick → permission char) |
| `perm_names` | Human-readable permission names |
| `online` | Currently online IRC users |
| `otazky` | Quiz questions — text, answer, topic, approval state, change requests |
| `temata` | Question topics/categories |
| `aktuality` | News/announcements |
| `hlasovani` | Poll questions |
| `hlasovani_odpovedi` | Poll answer options |
| `hlasovani_hlasy` | Individual poll votes (with IP tracking) |
| `otazky_chyby` | Reported question errors/bugs |
| `pass_req` | Password registration token requests (rate-limited) |
| `score_YYYY_M` | Per-user monthly score (dynamically named, e.g. `score_2026_3`) |
| `score_kviz1` | Legacy score table from the Kvíz 1.0 era |

## Cron jobs

| Script | Purpose |
|--------|---------|
| `graph/graph.sh` | Runs `graph/graph.php` and `graph/graph_score.php` to update RRD databases and regenerate PNG graphs. Should be scheduled to run periodically (e.g. every 5 minutes). |
