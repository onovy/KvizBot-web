#!/bin/bash
cd /var/www/html/
php -d safe_mode=0 graph/graph.php >/dev/null 2>&1
php -d safe_mode=0 graph/graph_score.php >/dev/null 2>&1
