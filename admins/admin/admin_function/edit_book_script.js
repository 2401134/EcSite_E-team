function showFileName(el, targetId) {
    // 選択されていないときのデフォルト文字
    let fileName = '選択されていません';
    // ファイル名短縮の長さ（必要なら変える）
    let maxLen = 30;

    // ファイルが選ばれていれば名前とサイズを取り出す
    if (el.files && el.files.length > 0) {
        // 1つ目のファイル情報を取得
        let f = el.files[0];
        // f.name がファイル名、f.size がバイト数
        fileName = f.name;

        // 長すぎる場合は切り詰める（例: 先頭15文字 + ... + 拡張子）
        if (fileName.length > maxLen) {
            // 拡張子を保持する処理
            let dotPos = fileName.lastIndexOf('.');
            let ext = '';
            if (dotPos !== -1) {
                ext = fileName.substring(dotPos); // 拡張子（.pdf など）
            }
            // 切り詰め本体
            let head = fileName.substring(0, maxLen - 3 - ext.length);
            fileName = head + '...' + ext;
        }

        // サイズを人間が読みやすい形式に変換（KB/MB）
        let sizeText = formatSize(f.size);
        fileName = fileName + ' (' + sizeText + ')';
    }

    // 書き換え先の要素を取得して中身を更新
    let target = document.getElementById(targetId);
    if (target) {
        target.innerHTML = fileName;
    } else {
        // デバッグ用：要素が見つからないときはコンソールに出す
        console.log('target element not found:', targetId);
    }
}

/* バイト数をKB/MBにする簡易関数 */
function formatSize(bytes) {
    // 1024単位で表示
    let kb = Math.round(bytes / 1024);
    if (kb < 1024) {
        return kb + ' KB';
    } else {
        let mb = (kb / 1024);
        // 小数点1桁までに整形
        let mbText = Math.round(mb * 10) / 10;
        return mbText + ' MB';
    }
}
