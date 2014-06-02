var TAG_BOLD = 0;
var TAG_ITALIC = 1;
var TAG_UNDERLINE = 2;
var TAG_HREF = 3;
var TAG_HREF_NW = 4;
var TAG_COLOR = 5;
var TAG_SIZE = 6;

var tags_open = new Array("B", "I", "U", "A ","A_NW ","COLOR ","SIZE ");
var tags_close = new Array("B", "I", "U", "A","A","COLOR","SIZE");

function editor_add_token(token)
{
  this.element.value += token;
  this.element.focus();
}

function editor_add_tag(tag)
{
  var token = "[";
  if(this.state[tag] == true)
    token += "/" + tags_close[tag];
  else
    token += tags_open[tag];
  token += "]";
  this.addToken(token);

  this.state[tag] = (this.state[tag] == true ? false : true);
}

function Editor(name, id)
{
  this.state = new Array(false, false, false, false);

  document.writeln("<INPUT TYPE=\"BUTTON\" VALUE=\" B \" STYLE=\"font-weight: bold; width=30px;\" onClick=\"" + name + ".addTag(" + TAG_BOLD + ");\">");
  document.writeln("<INPUT TYPE=\"BUTTON\" VALUE=\" I \" STYLE=\"font-style: italic; width: 30px;\" \" onClick=\"" + name + ".addTag(" + TAG_ITALIC + ");\">");
  document.writeln("<INPUT TYPE=\"BUTTON\" VALUE=\" U \" STYLE=\"text-decoration: underline; width: 30px;\" onClick=\"" + name + ".addTag(" + TAG_UNDERLINE + ");\">");
  document.writeln("<INPUT TYPE=\"BUTTON\" VALUE=\" A \" onClick=\"" + name + ".addTag(" + TAG_HREF + ");\">");
  document.writeln("<INPUT TYPE=\"BUTTON\" VALUE=\" A (nové okno)\" onClick=\"" + name + ".addTag(" + TAG_HREF_NW + ");\">");
  document.writeln("<INPUT TYPE=\"BUTTON\" VALUE=\" Barva \" STYLE=\"color: red;\" onClick=\"" + name + ".addTag(" + TAG_COLOR + ");\">");
  document.writeln("<INPUT TYPE=\"BUTTON\" VALUE=\" Velikost \" STYLE=\"color: green;\" onClick=\"" + name + ".addTag(" + TAG_SIZE + ");\">");

  this.element = document.getElementById(id);

  this.addToken = editor_add_token;
  this.addTag = editor_add_tag;
}
