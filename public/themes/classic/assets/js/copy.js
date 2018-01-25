$(document).ready(function () {
    // console.log($("#copy_clipboard").length);
    if ($("#copy_clipboard").length) {
        document.getElementById("copy_clipboard").addEventListener("click", function () {
            $("#tAText").val(window.location.href);
            if (copyToClipboard(document.getElementById("tAText"))) {
                Popup.show("#copy_done")
            }
        })
    }
});

function copyToClipboard(c) {
    var j = "_hiddenCopyText_";
    var i = c.tagName === "INPUT" || c.tagName === "TEXTAREA";
    var f, b;
    if (i) {
        h = c;
        f = c.selectionStart;
        b = c.selectionEnd
    } else {
        h = document.getElementById(j);
        if (!h) {
            var h = document.createElement("textarea");
            h.style.position = "absolute";
            h.style.left = "-9999px";
            h.style.top = "0";
            h.id = j;
            document.body.appendChild(h)
        }
        h.textContent = c.textContent
    }
    var a = document.activeElement;
    h.focus();
    h.setSelectionRange(0, h.value.length);
    var d;
    try {
        d = document.execCommand("copy")
    } catch (g) {
        d = false
    }
    if (a && typeof a.focus === "function") {
        a.focus()
    }
    if (i) {
        c.setSelectionRange(f, b)
    } else {
        h.textContent = ""
    }
    return d
}