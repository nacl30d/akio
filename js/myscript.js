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



