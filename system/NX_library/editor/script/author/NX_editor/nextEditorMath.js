
/** for font Family **/
var fonts = document.querySelectorAll("select#fontChanger > option");
for(var face = 0; face < fonts.length; face++){
	fonts[face].style.fontFamily = fonts[face].value;
}

/** for iframe js**/
window.addEventListener("load", function(){
	pasteTextAreaData();
	
	var editor = theNEXTeditor.document;
	editor.designMode = "on";
	
	/*For bold text*/
	boldButton.addEventListener("click", function(){
		editor.execCommand("Bold", false, null);
	}, false);
	
	/*For italic text*/
	italicButton.addEventListener("click", function(){
		editor.execCommand("Italic", false, null);
	}, false);
	
	/*Text underline*/
	underlineButton.addEventListener("click", function(){
		editor.execCommand("Underline", false, null);
	},false);
	
	
	/*For super lavel text*/
	supButton.addEventListener("click", function(){
		editor.execCommand("Superscript", false, null);
	}, false);
	
	
	/*For sub lavel text*/
	subButton.addEventListener("click", function(){
		editor.execCommand("Subscript", false, null);
	}, false);
	
	
	/*For strikeButton text*/
	strikeButton.addEventListener("click", function(){
		editor.execCommand("Strikethrough", false, null);
	}, false);
	
	/*Text left*/
	leftButton.addEventListener("click", function(){
		editor.execCommand("JustifyLeft", false, null);
	},false);
	
	/*Text Center*/
	centerButton.addEventListener("click", function(){
		editor.execCommand("JustifyCenter", false, null);
	},false);
	
	/*Text Right*/
	rightButton.addEventListener("click", function(){
		editor.execCommand("JustifyRight", false, null);
	},false);
	
	
	/*For Order list text*/
	orderedListButton.addEventListener("click", function(){
		editor.execCommand("InsertOrderedList", false, "newOL", + Math.round(Math.random() * 1000));
	}, false);
	
	/*For Un Order list text*/
	unorderedListButton.addEventListener("click", function(){
		editor.execCommand("InsertUnorderedList", false, "newUL", + Math.round(Math.random() * 1000));
	}, false);
	
	/*For font family change*/
	fontChanger.addEventListener("change", function(event){
		editor.execCommand("FontName", false, event.target.value);
	}, false);
	
	/*For font size change*/
	fontSizeChanger.addEventListener("change", function(event){
		editor.execCommand("FontSize", false, event.target.value);
	}, false);
	
	/*color text*/
	fontColorButton.addEventListener("change", function(event){
		editor.execCommand("ForeColor", false, event.target.value);
	}, false);
	
	/*For undo button */
	undoButton.addEventListener("click", function(){
		editor.execCommand("undo", false, null);
	}, false);
	
	/*For redo button */
	redoButton.addEventListener("click", function(){
		editor.execCommand("redo", false, null);
	}, false);
	
	
}, false);

/*********** text area paste data*******/
function pasteTextAreaData(){
	var textArea = document.getElementById(editorId);
	textArea.style.display = 'none';
	window.frames['theNEXTeditor'].document.body.innerHTML = textArea.value;
	copyTextArea();
}

theNEXTeditor.addEventListener("keyup", function(){
	copyTextArea();
}, false);

theNEXTeditor.addEventListener("mouseout", function(){
	copyTextArea();
}, false);

theNEXTeditor.addEventListener("click", function(){
	copyTextArea();
}, false);

function copyTextArea(){
	var textArea = document.getElementById(editorId);
	//alert(textArea);
	textArea.innerHTML = window.frames['theNEXTeditor'].document.body.innerHTML;
	
	var tmp = document.createElement("div");
    tmp.innerHTML = textArea.value;
    var textTotal =  tmp.textContent || tmp.innerText || "";
	
	var totalWord = textTotal.length;
	var textWords = ' char';
	if(totalWord > 1){
		textWords = ' chars';
	}
	document.getElementById('total_count').innerHTML = totalWord+textWords;
	
}


var dataDev = '<span style="float:right; margin-right:3px; margin-top:3px; font-size:12px;" title="Develop by Golap Hazi - golaphazi@gmail.com"> <i class="fa fa-question"></i> </span>';
var table = document.getElementById("redoButton");
table.insertAdjacentHTML('afterend', dataDev);
