//時間割フォームの各セルがクリックされたときのイベント
function judge(id) {
	var obj = document.getElementById(id); //td要素を取得
	var hid = document.getElementById('a' + id); //input hiddenのvalueを取得
	//クラスの変更。クラスを変更するとセルの背景色が変わる (UI)
	//input hiddenのvalueを変更
	if (obj.className != "ng") {
		obj.className = "ng";
		hid.value = "0";
	} else {
		obj.className = "ok";
		hid.value = "1";
	}
}



function addRow() {
	var hoge = document.getElementById('r5').innerHTML;
	console.log(hoge);
	document.getElementById('createForm').innerHTML += '<tr><th><input type="text" value="hoge" name="hoge" /></th>';
	console.log(document.getElementById('createForm').innerHTML);
	console.log(hoge);
}

function addCol() {
	var head = document.getElementById('day').innerHTML;
	head += '<th><input type="text" value="fuga" name="dx"/></th>';
	console.log(document.getElementById('day'));
	for (var i = 0; i < 5; i++) {
		var row = document.getElementById('r'+i).innerHTML;
		console.log(row);
		row += '<td></td>';
	}
	console.log(document.getElementById('createForm').innerHTML);
}