// Globalni pole
var editors = new Array();
var editors_pos = 0;

// Konstanty
var tags =
    new Array("B","I","U","A","COLOR","SIZE");
var tags_name =
    new Array("Tuènì","Kurzíva","Podtr¾ení","Odkaz","Barva","Velikost");
var tags_img =
    new Array("bold","italic","underline","link","color","size");
var tags_style =
    new Array("font-weight: bold",
	      "font-style: italic",
	      "text-decoration: underline",
	      "color: #00f; text-decoration: underline",
	      "color: #f00",
	      "font-size: 1.1em");

/*
 * Vlozi na aktualni pozici kurzoru text
 *
 * @see http://www.alexking.org/index.php?content=software/javascript/content.php
 */
function ot2html_addToken(value) {
  field = this.element;

  //IE support
  if (document.selection) {
    field.focus();
    sel = document.selection.createRange();
    sel.text = value;
  //MOZILLA/NETSCAPE support
  }else if (field.selectionStart || field.selectionStart == '0') {
    var startPos  = field.selectionStart;
    var endPos    = field.selectionEnd;
    var scrollTop = field.scrollTop;
    field.value = field.value.substring(0, startPos)
                  + value
                  + field.value.substring(endPos, field.value.length);

    field.focus();
    var cPos=startPos+(value.length);
    field.selectionStart=cPos;
    field.selectionEnd=cPos;
    field.scrollTop=scrollTop;
  } else {
    field.value += "\n"+value;
  }
  // reposition cursor if possible
  if (field.createTextRange) field.caretPos = document.selection.createRange().duplicate();
}

function ot2html_addTag(id) {
    var but = document.getElementById("OT-" + this.id + "-buttonTag-" + id);

    if (this.tags_state[id]) {
	if (this.tags_open[this.tags_open.length-1] != id) {
	    alert('Tento TAG neni mozne nyni zavrit! Musite dodrzet poradi');
	    return;
	} 
    	this.tags_open.length -= 1;
	this.repaintHistory();

	this.addToken("[/" + tags[id] + "]");
	but.className='button_off';
    } else {
	this.tags_open[this.tags_open.length] = id;
	this.repaintHistory();

	this.addToken("[" + tags[id] + "]");
	but.className='button_on';
    }
    this.tags_state[id]=!this.tags_state[id];
}

function ot2html_closeLastTag() {
    if (this.tags_open.length == 0) {
	this.element.focus();
	return;
    }

    var id = this.tags_open[this.tags_open.length-1];
    var but = document.getElementById("OT-" + this.id + "-buttonTag-" + id);

    this.addToken("[/" + tags[id] + "]");
    but.className='button_off';

    this.tags_state[id]=false;

    this.tags_open.length -= 1;
    this.repaintHistory();
}

function ot2html_closeAllTags() {
    var out = "";

    for(i=this.tags_open.length-1;i>=0;i--){
	var id = this.tags_open[i];
	var but = document.getElementById("OT-" + this.id + "-buttonTag-" + id);

	out += "[/" + tags[id] + "]";
	but.className='button_off';
	this.tags_state[id]=false;
    }
    if (out == '') {
	this.element.focus();
    } else {
	this.addToken(out);
	this.tags_open.length = 0;
    }
    this.repaintHistory();
}

function ot2html_addH(id) {
    this.closeAllTags();

    if (this.element.value == '') {
	var text = "";
    } else {
	var text = "\n";
    }
    for(i=0;i<=id;i++){
	text += "=";
    }
    text += "  ";
    for(i=0;i<=id;i++){
	text += "=";
    }
    this.addToken(text);
}

function ot2html_addHR() {
    this.closeAllTags();

    if (this.element.value == '') {
	this.element.focus();
	return;
    } else {
	this.addToken("\n----\n");
    }
}

function ot2html_addList() {
    this.closeAllTags();

    this.addToken("* ");
}

function ot2html_addListNum() {
    this.closeAllTags();

    this.addToken("# ");
}

function ot2html_writeTextArea() {
    document.writeln("<textarea name=\"" + this.name + "\" id=\"editor-" + this.id + "\" cols=\"" + this.cols + "\" rows=\"" + this.rows+ "\">" + this.value + "</textarea><br />");
}

function ot2html_writeHistory() {
    document.writeln("Otevøené tagy:<br /><textarea name=\"editorH-" + this.id + "\" id=\"editorH-" + this.id + "\" cols=\"15\" rows=\"10\" readonly=\"readonly\"></textarea><br />");
}

function ot2html_repaintHistory() {
    var out = "";
    for(i=this.tags_open.length-1;i>=0;i--){
	out += tags[this.tags_open[i]] + ": " + tags_name[this.tags_open[i]] + "\n";
    }
    this.elementH.value=out;
}


function ot2html_addbutton(img,class_,id,onClick) {
    document.write("<input type=\"image\" src=\"onovyPHPlib/img/ot2html/" + img + ".png\" class=\"" + class_ + "\" id=\"" + id + "\" onClick=\"" + onClick + "; return false;\">");
}

function ot2html(name,value,cols,rows) {
// funkce
    this.writeTextArea = ot2html_writeTextArea;
    this.writeHistory = ot2html_writeHistory;
    this.addTag = ot2html_addTag;
    this.addToken = ot2html_addToken;
    this.closeLastTag = ot2html_closeLastTag;
    this.closeAllTags = ot2html_closeAllTags;
    this.addH = ot2html_addH;
    this.addHR = ot2html_addHR;
    this.addList = ot2html_addList;
    this.addListNum = ot2html_addListNum;
    this.repaintHistory = ot2html_repaintHistory;
// ---

    this.name = name;
    this.cols = cols;
    this.rows = rows;
    this.value = value;

    this.id = editors_pos;
    editors[editors_pos] = this;
    editors_pos++;

    this.tags_state = new Array();
    this.tags_open = new Array();

    document.writeln("<table class='form' cellspacing='0'><tr><td><br />");
    this.writeTextArea();
    
    // Rozinani cudlu
    document.writeln("<style type='text/css'>\n" +
    ".button_on\n"+
    "{ border: 2px solid #f00; }\n"+
    ".button_off\n"+
    "{ border: 2px solid #fff; }\n"+
    "</style>");
    
    // Zakladni tagy
    for(i=0;i<tags.length;i++){
	this.tags_state[i]=false;
        ot2html_addbutton(tags_img[i],"button_off","OT-" + this.id + "-buttonTag-" + i,"editors[" + this.id + "].addTag(" + i + ");");
    }

    // HR
    ot2html_addbutton("hr","button_off","OT-" + this.id + "-buttonHR","editors[" + this.id + "].addHR();");

    // Seznamy
    ot2html_addbutton("list","button_off","OT-" + this.id + "-buttonList","editors[" + this.id + "].addList();");
    ot2html_addbutton("list_num","button_off","OT-" + this.id + "-buttonListNum","editors[" + this.id + "].addListNum();");

    // Auto-zavirani
    ot2html_addbutton("closelast","button_off","OT-" + this.id + "-buttonClast","editors[" + this.id + "].closeLastTag();");
    ot2html_addbutton("closeall","button_off","OT-" + this.id + "-buttonCall","editors[" + this.id + "].closeAllTags();");

    document.writeln("<br />");

    // Nadpisy
    for(i=1;i<=5;i++){
	ot2html_addbutton("h" + i,"button_off","OT-" + this.id + "-buttonH-" + i,"editors[" + this.id + "].addH(" + i + ");");
    }

    // TagHistory
    document.writeln("</td><td valign='top'>");
    this.writeHistory();
    document.writeln("</td></tr></table>");
    
    this.element = document.getElementById("editor-" + this.id);
    this.elementH = document.getElementById("editorH-" + this.id);
}
