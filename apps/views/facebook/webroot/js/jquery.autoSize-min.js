// Autosize 1.6 - jQuery plugin for textareas
// (c) 2011 Jack Moore - jacklmoore.com
// license: www.opensource.org/licenses/mit-license.php
(function(a, b) {
    var c = "hidden", d = '<textarea style="position:absolute; top:-9999px; left:-9999px; right:auto; bottom:auto; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden">', e = ["fontFamily", "fontSize", "fontWeight", "fontStyle", "letterSpacing", "textTransform", "wordSpacing"], f = "oninput", g = "onpropertychange", h = a(d)[0];
    h.setAttribute(f, "return"), a.isFunction(h[f]) || g in h ? a.fn.autosize = function(b) {
        return this.each(function() {
            function o() {
                var a, b;
                m || (m = !0, j.value = h.value, j.style.overflowY = h.style.overflowY, j.style.width = i.css("width"), j.scrollTop = 0, j.scrollTop = 9e4, a = j.scrollTop, b = c, a > l ? (a = l, b = "scroll") : a < k && (a = k), h.style.overflowY = b, h.style.height = h.style.minHeight = h.style.maxHeight = a + "px", setTimeout(function() {
                    m = !1
                }, 1))
            }
            var h = this, i = a(h).css({overflow: c, overflowY: c, wordWrap: "break-word"}), j = a(d).addClass(b || "autosizejs")[0], k = i.height(), l = parseInt(i.css("maxHeight"), 10), m, n = e.length;
            l = l && l > 0 ? l : 9e4;
            while (n--)
                j.style[e[n]] = i.css(e[n]);
            a("body").append(j), g in h ? f in h ? h[f] = h.onkeyup = o : h[g] = o : h[f] = o, a(window).resize(o), i.bind("autosize", o), o()
        })
    } : a.fn.autosize = function() {
        return this
    }
})(jQuery);