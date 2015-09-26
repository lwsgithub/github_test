var FrameClient = (function() {
    var a = (function() {
        var c = {};
        var d = [];
        c.inc = function(f, e) {
            return true
        };
        c.register = function(g, e) {
            var i = g.split(".");
            var h = c;
            var f = null;
            while (f = i.shift()) {
                if (i.length) {
                    if (h[f] === undefined) {
                        h[f] = {}
                    }
                    h = h[f]
                } else {
                    if (h[f] === undefined) {
                        try {
                            h[f] = e(c)
                        } catch(j) {
                            d.push(j)
                        }
                    }
                }
            }
        };
        c.regShort = function(e, f) {
            if (c[e] !== undefined) {
                throw "[" + e + "] : short : has been register"
            }
            c[e] = f
        };
        c.IE = /msie/i.test(navigator.userAgent);
        c.E = function(e) {
            if (typeof e === "string") {
                return document.getElementById(e)
            } else {
                return e
            }
        };
        c.C = function(e) {
            var f;
            e = e.toUpperCase();
            if (e == "TEXT") {
                f = document.createTextNode("")
            } else {
                if (e == "BUFFER") {
                    f = document.createDocumentFragment()
                } else {
                    f = document.createElement(e)
                }
            }
            return f
        };
        c.log = function(e) {
            d.push("[" + ((new Date()).getTime() % 100000) + "]: " + e)
        };
        c.getErrorLogInformationList = function(e) {
            return d.splice(0, e || d.length)
        };
        return c
    })();
    $Import = a.inc;
    a.register("core.evt.addEvent",
    function(c) {
        return function(d, g, f) {
            var e = c.E(d);
            if (e == null) {
                return false
            }
            g = g || "click";
            if ((typeof f).toLowerCase() != "function") {
                return
            }
            if (e.addEventListener) {
                e.addEventListener(g, f, false)
            } else {
                if (e.attachEvent) {
                    e.attachEvent("on" + g, f)
                } else {
                    e["on" + g] = f
                }
            }
            return true
        }
    });
    a.register("core.util.browser",
    function(j) {
        var c = navigator.userAgent.toLowerCase();
        var p = window.external || "";
        var f, g, h, q, i;
        var d = function(e) {
            var m = 0;
            return parseFloat(e.replace(/\./g,
            function() {
                return (m++==1) ? "": "."
            }))
        };
        try {
            if ((/windows|win32/i).test(c)) {
                i = "windows"
            } else {
                if ((/macintosh/i).test(c)) {
                    i = "macintosh"
                } else {
                    if ((/rhino/i).test(c)) {
                        i = "rhino"
                    }
                }
            }
            if ((g = c.match(/applewebkit\/([^\s]*)/)) && g[1]) {
                f = "webkit";
                q = d(g[1])
            } else {
                if ((g = c.match(/presto\/([\d.]*)/)) && g[1]) {
                    f = "presto";
                    q = d(g[1])
                } else {
                    if (g = c.match(/msie\s([^;]*)/)) {
                        f = "trident";
                        q = 1;
                        if ((g = c.match(/trident\/([\d.]*)/)) && g[1]) {
                            q = d(g[1])
                        }
                    } else {
                        if (/gecko/.test(c)) {
                            f = "gecko";
                            q = 1;
                            if ((g = c.match(/rv:([\d.]*)/)) && g[1]) {
                                q = d(g[1])
                            }
                        }
                    }
                }
            }
            if (/world/.test(c)) {
                h = "world"
            } else {
                if (/360se/.test(c)) {
                    h = "360"
                } else {
                    if ((/maxthon/.test(c)) || typeof p.max_version == "number") {
                        h = "maxthon"
                    } else {
                        if (/tencenttraveler\s([\d.]*)/.test(c)) {
                            h = "tt"
                        } else {
                            if (/se\s([\d.]*)/.test(c)) {
                                h = "sogou"
                            }
                        }
                    }
                }
            }
        } catch(o) {}
        var n = {
            OS: i,
            CORE: f,
            Version: q,
            EXTRA: (h ? h: false),
            IE: /msie/.test(c),
            OPERA: /opera/.test(c),
            MOZ: /gecko/.test(c) && !/(compatible|webkit)/.test(c),
            IE5: /msie 5 /.test(c),
            IE55: /msie 5.5/.test(c),
            IE6: /msie 6/.test(c),
            IE7: /msie 7/.test(c),
            IE8: /msie 8/.test(c),
            IE9: /msie 9/.test(c),
            SAFARI: !/chrome\/([\d.]*)/.test(c) && /\/([\d.]*) safari/.test(c),
            CHROME: /chrome\/([\d.]*)/.test(c),
            IPAD: /\(ipad/i.test(c),
            IPHONE: /\(iphone/i.test(c),
            ITOUCH: /\(itouch/i.test(c),
            MOBILE: /mobile/i.test(c)
        };
        return n
    });
    a.register("core.evt.getEvent",
    function(c) {
        return function() {
            if (c.IE) {
                return window.event
            } else {
                if (window.event) {
                    return window.event
                }
                var f = arguments.callee.caller;
                var d;
                var g = 0;
                while (f != null && g < 40) {
                    d = f.arguments[0];
                    if (d && (d.constructor == Event || d.constructor == MouseEvent || d.constructor == KeyboardEvent)) {
                        return d
                    }
                    g++;
                    f = f.caller
                }
                return d
            }
        }
    });
    a.register("core.evt.preventDefault",
    function(c) {
        return function(f) {
            var d = f ? f: c.core.evt.getEvent();
            if (c.IE) {
                d.returnValue = false
            } else {
                d.preventDefault()
            }
        }
    });
    a.register("core.evt.stopEvent",
    function(c) {
        return function(f) {
            var d = f ? f: c.core.evt.getEvent();
            if (c.IE) {
                d.cancelBubble = true;
                d.returnValue = false
            } else {
                d.preventDefault();
                d.stopPropagation()
            }
            return false
        }
    });
    a.register("core.arr.isArray",
    function(c) {
        return function(d) {
            return Object.prototype.toString.call(d) === "[object Array]"
        }
    });
    a.register("core.str.trim",
    function(c) {
        return function(g) {
            if (typeof g !== "string") {
                throw "trim need a string as parameter"
            }
            var d = g.length;
            var f = 0;
            var e = /(\u3000|\s|\t|\u00A0)/;
            while (f < d) {
                if (!e.test(g.charAt(f))) {
                    break
                }
                f += 1
            }
            while (d > f) {
                if (!e.test(g.charAt(d - 1))) {
                    break
                }
                d -= 1
            }
            return g.slice(f, d)
        }
    });
    a.register("core.json.queryToJson",
    function(c) {
        return function(f, m) {
            var o = c.core.str.trim(f).split("&");
            var n = {};
            var e = function(i) {
                if (m) {
                    return decodeURIComponent(i)
                } else {
                    return i
                }
            };
            for (var h = 0,
            j = o.length; h < j; h++) {
                if (o[h]) {
                    var g = o[h].split("=");
                    var d = g[0];
                    var p = g[1];
                    if (g.length < 2) {
                        p = d;
                        d = "$nullName"
                    }
                    if (!n[d]) {
                        n[d] = e(p)
                    } else {
                        if (c.core.arr.isArray(n[d]) != true) {
                            n[d] = [n[d]]
                        }
                        n[d].push(e(p))
                    }
                }
            }
            return n
        }
    });
    a.register("core.dom.isNode",
    function(c) {
        return function(d) {
            return (d != undefined) && Boolean(d.nodeName) && Boolean(d.nodeType)
        }
    });
    a.register("core.dom.sizzle",
    function(o) {
        var u = /((?:\((?:\([^()]+\)|[^()]+)+\)|\[(?:\[[^\[\]]*\]|['"][^'"]*['"]|[^\[\]'"]+)+\]|\\.|[^ >+~,(\[\\]+)+|[>+~])(\s*,\s*)?((?:.|\r|\n)*)/g,
        n = 0,
        g = Object.prototype.toString,
        t = false,
        m = true; [0, 0].sort(function() {
            m = false;
            return 0
        });
        var d = function(A, e, D, E) {
            D = D || [];
            e = e || document;
            var G = e;
            if (e.nodeType !== 1 && e.nodeType !== 9) {
                return []
            }
            if (!A || typeof A !== "string") {
                return D
            }
            var B = [],
            x,
            I,
            L,
            w,
            z = true,
            y = d.isXML(e),
            F = A,
            H,
            K,
            J,
            C;
            do {
                u.exec("");
                x = u.exec(F);
                if (x) {
                    F = x[3];
                    B.push(x[1]);
                    if (x[2]) {
                        w = x[3];
                        break
                    }
                }
            } while ( x );
            if (B.length > 1 && p.exec(A)) {
                if (B.length === 2 && h.relative[B[0]]) {
                    I = j(B[0] + B[1], e)
                } else {
                    I = h.relative[B[0]] ? [e] : d(B.shift(), e);
                    while (B.length) {
                        A = B.shift();
                        if (h.relative[A]) {
                            A += B.shift()
                        }
                        I = j(A, I)
                    }
                }
            } else {
                if (!E && B.length > 1 && e.nodeType === 9 && !y && h.match.ID.test(B[0]) && !h.match.ID.test(B[B.length - 1])) {
                    H = d.find(B.shift(), e, y);
                    e = H.expr ? d.filter(H.expr, H.set)[0] : H.set[0]
                }
                if (e) {
                    H = E ? {
                        expr: B.pop(),
                        set: c(E)
                    }: d.find(B.pop(), B.length === 1 && (B[0] === "~" || B[0] === "+") && e.parentNode ? e.parentNode: e, y);
                    I = H.expr ? d.filter(H.expr, H.set) : H.set;
                    if (B.length > 0) {
                        L = c(I)
                    } else {
                        z = false
                    }
                    while (B.length) {
                        K = B.pop();
                        J = K;
                        if (!h.relative[K]) {
                            K = ""
                        } else {
                            J = B.pop()
                        }
                        if (J == null) {
                            J = e
                        }
                        h.relative[K](L, J, y)
                    }
                } else {
                    L = B = []
                }
            }
            if (!L) {
                L = I
            }
            if (!L) {
                d.error(K || A)
            }
            if (g.call(L) === "[object Array]") {
                if (!z) {
                    D.push.apply(D, L)
                } else {
                    if (e && e.nodeType === 1) {
                        for (C = 0; L[C] != null; C++) {
                            if (L[C] && (L[C] === true || L[C].nodeType === 1 && d.contains(e, L[C]))) {
                                D.push(I[C])
                            }
                        }
                    } else {
                        for (C = 0; L[C] != null; C++) {
                            if (L[C] && L[C].nodeType === 1) {
                                D.push(I[C])
                            }
                        }
                    }
                }
            } else {
                c(L, D)
            }
            if (w) {
                d(w, G, D, E);
                d.uniqueSort(D)
            }
            return D
        };
        d.uniqueSort = function(w) {
            if (f) {
                t = m;
                w.sort(f);
                if (t) {
                    for (var e = 1; e < w.length; e++) {
                        if (w[e] === w[e - 1]) {
                            w.splice(e--, 1)
                        }
                    }
                }
            }
            return w
        };
        d.matches = function(e, w) {
            return d(e, null, null, w)
        };
        d.find = function(C, e, D) {
            var B;
            if (!C) {
                return []
            }
            for (var y = 0,
            x = h.order.length; y < x; y++) {
                var A = h.order[y],
                z;
                if ((z = h.leftMatch[A].exec(C))) {
                    var w = z[1];
                    z.splice(1, 1);
                    if (w.substr(w.length - 1) !== "\\") {
                        z[1] = (z[1] || "").replace(/\\/g, "");
                        B = h.find[A](z, e, D);
                        if (B != null) {
                            C = C.replace(h.match[A], "");
                            break
                        }
                    }
                }
            }
            if (!B) {
                B = e.getElementsByTagName("*")
            }
            return {
                set: B,
                expr: C
            }
        };
        d.filter = function(G, F, J, z) {
            var x = G,
            L = [],
            D = F,
            B,
            e,
            C = F && F[0] && d.isXML(F[0]);
            while (G && F.length) {
                for (var E in h.filter) {
                    if ((B = h.leftMatch[E].exec(G)) != null && B[2]) {
                        var w = h.filter[E],
                        K,
                        I,
                        y = B[1];
                        e = false;
                        B.splice(1, 1);
                        if (y.substr(y.length - 1) === "\\") {
                            continue
                        }
                        if (D === L) {
                            L = []
                        }
                        if (h.preFilter[E]) {
                            B = h.preFilter[E](B, D, J, L, z, C);
                            if (!B) {
                                e = K = true
                            } else {
                                if (B === true) {
                                    continue
                                }
                            }
                        }
                        if (B) {
                            for (var A = 0; (I = D[A]) != null; A++) {
                                if (I) {
                                    K = w(I, B, A, D);
                                    var H = z ^ !!K;
                                    if (J && K != null) {
                                        if (H) {
                                            e = true
                                        } else {
                                            D[A] = false
                                        }
                                    } else {
                                        if (H) {
                                            L.push(I);
                                            e = true
                                        }
                                    }
                                }
                            }
                        }
                        if (K !== undefined) {
                            if (!J) {
                                D = L
                            }
                            G = G.replace(h.match[E], "");
                            if (!e) {
                                return []
                            }
                            break
                        }
                    }
                }
                if (G === x) {
                    if (e == null) {
                        d.error(G)
                    } else {
                        break
                    }
                }
                x = G
            }
            return D
        };
        d.error = function(e) {
            throw "Syntax error, unrecognized expression: " + e
        };
        var h = {
            order: ["ID", "NAME", "TAG"],
            match: {
                ID: /#((?:[\w\u00c0-\uFFFF\-]|\\.)+)/,
                CLASS: /\.((?:[\w\u00c0-\uFFFF\-]|\\.)+)/,
                NAME: /\[name=['"]*((?:[\w\u00c0-\uFFFF\-]|\\.)+)['"]*\]/,
                ATTR: /\[\s*((?:[\w\u00c0-\uFFFF\-]|\\.)+)\s*(?:(\S?=)\s*(['"]*)(.*?)\3|)\s*\]/,
                TAG: /^((?:[\w\u00c0-\uFFFF\*\-]|\\.)+)/,
                CHILD: /:(only|nth|last|first)-child(?:\((even|odd|[\dn+\-]*)\))?/,
                POS: /:(nth|eq|gt|lt|first|last|even|odd)(?:\((\d*)\))?(?=[^\-]|$)/,
                PSEUDO: /:((?:[\w\u00c0-\uFFFF\-]|\\.)+)(?:\((['"]?)((?:\([^\)]+\)|[^\(\)]*)+)\2\))?/
            },
            leftMatch: {},
            attrMap: {
                "class": "className",
                "for": "htmlFor"
            },
            attrHandle: {
                href: function(e) {
                    return e.getAttribute("href")
                }
            },
            relative: {
                "+": function(B, w) {
                    var y = typeof w === "string",
                    A = y && !/\W/.test(w),
                    C = y && !A;
                    if (A) {
                        w = w.toLowerCase()
                    }
                    for (var x = 0,
                    e = B.length,
                    z; x < e; x++) {
                        if ((z = B[x])) {
                            while ((z = z.previousSibling) && z.nodeType !== 1) {}
                            B[x] = C || z && z.nodeName.toLowerCase() === w ? z || false: z === w
                        }
                    }
                    if (C) {
                        d.filter(w, B, true)
                    }
                },
                ">": function(B, w) {
                    var z = typeof w === "string",
                    A, x = 0,
                    e = B.length;
                    if (z && !/\W/.test(w)) {
                        w = w.toLowerCase();
                        for (; x < e; x++) {
                            A = B[x];
                            if (A) {
                                var y = A.parentNode;
                                B[x] = y.nodeName.toLowerCase() === w ? y: false
                            }
                        }
                    } else {
                        for (; x < e; x++) {
                            A = B[x];
                            if (A) {
                                B[x] = z ? A.parentNode: A.parentNode === w
                            }
                        }
                        if (z) {
                            d.filter(w, B, true)
                        }
                    }
                },
                "": function(y, w, A) {
                    var x = n++,
                    e = v,
                    z;
                    if (typeof w === "string" && !/\W/.test(w)) {
                        w = w.toLowerCase();
                        z = w;
                        e = s
                    }
                    e("parentNode", w, x, y, z, A)
                },
                "~": function(y, w, A) {
                    var x = n++,
                    e = v,
                    z;
                    if (typeof w === "string" && !/\W/.test(w)) {
                        w = w.toLowerCase();
                        z = w;
                        e = s
                    }
                    e("previousSibling", w, x, y, z, A)
                }
            },
            find: {
                ID: function(w, x, y) {
                    if (typeof x.getElementById !== "undefined" && !y) {
                        var e = x.getElementById(w[1]);
                        return e ? [e] : []
                    }
                },
                NAME: function(x, A) {
                    if (typeof A.getElementsByName !== "undefined") {
                        var w = [],
                        z = A.getElementsByName(x[1]);
                        for (var y = 0,
                        e = z.length; y < e; y++) {
                            if (z[y].getAttribute("name") === x[1]) {
                                w.push(z[y])
                            }
                        }
                        return w.length === 0 ? null: w
                    }
                },
                TAG: function(e, w) {
                    return w.getElementsByTagName(e[1])
                }
            },
            preFilter: {
                CLASS: function(y, w, x, e, B, C) {
                    y = " " + y[1].replace(/\\/g, "") + " ";
                    if (C) {
                        return y
                    }
                    for (var z = 0,
                    A; (A = w[z]) != null; z++) {
                        if (A) {
                            if (B ^ (A.className && (" " + A.className + " ").replace(/[\t\n]/g, " ").indexOf(y) >= 0)) {
                                if (!x) {
                                    e.push(A)
                                }
                            } else {
                                if (x) {
                                    w[z] = false
                                }
                            }
                        }
                    }
                    return false
                },
                ID: function(e) {
                    return e[1].replace(/\\/g, "")
                },
                TAG: function(w, e) {
                    return w[1].toLowerCase()
                },
                CHILD: function(e) {
                    if (e[1] === "nth") {
                        var w = /(-?)(\d*)n((?:\+|-)?\d*)/.exec(e[2] === "even" && "2n" || e[2] === "odd" && "2n+1" || !/\D/.test(e[2]) && "0n+" + e[2] || e[2]);
                        e[2] = (w[1] + (w[2] || 1)) - 0;
                        e[3] = w[3] - 0
                    }
                    e[0] = n++;
                    return e
                },
                ATTR: function(z, w, x, e, A, B) {
                    var y = z[1].replace(/\\/g, "");
                    if (!B && h.attrMap[y]) {
                        z[1] = h.attrMap[y]
                    }
                    if (z[2] === "~=") {
                        z[4] = " " + z[4] + " "
                    }
                    return z
                },
                PSEUDO: function(z, w, x, e, A) {
                    if (z[1] === "not") {
                        if ((u.exec(z[3]) || "").length > 1 || /^\w/.test(z[3])) {
                            z[3] = d(z[3], null, null, w)
                        } else {
                            var y = d.filter(z[3], w, x, true ^ A);
                            if (!x) {
                                e.push.apply(e, y)
                            }
                            return false
                        }
                    } else {
                        if (h.match.POS.test(z[0]) || h.match.CHILD.test(z[0])) {
                            return true
                        }
                    }
                    return z
                },
                POS: function(e) {
                    e.unshift(true);
                    return e
                }
            },
            filters: {
                enabled: function(e) {
                    return e.disabled === false && e.type !== "hidden"
                },
                disabled: function(e) {
                    return e.disabled === true
                },
                checked: function(e) {
                    return e.checked === true
                },
                selected: function(e) {
                    e.parentNode.selectedIndex;
                    return e.selected === true
                },
                parent: function(e) {
                    return !! e.firstChild
                },
                empty: function(e) {
                    return ! e.firstChild
                },
                has: function(x, w, e) {
                    return !! d(e[3], x).length
                },
                header: function(e) {
                    return (/h\d/i).test(e.nodeName)
                },
                text: function(e) {
                    return "text" === e.type
                },
                radio: function(e) {
                    return "radio" === e.type
                },
                checkbox: function(e) {
                    return "checkbox" === e.type
                },
                file: function(e) {
                    return "file" === e.type
                },
                password: function(e) {
                    return "password" === e.type
                },
                submit: function(e) {
                    return "submit" === e.type
                },
                image: function(e) {
                    return "image" === e.type
                },
                reset: function(e) {
                    return "reset" === e.type
                },
                button: function(e) {
                    return "button" === e.type || e.nodeName.toLowerCase() === "button"
                },
                input: function(e) {
                    return (/input|select|textarea|button/i).test(e.nodeName)
                }
            },
            setFilters: {
                first: function(w, e) {
                    return e === 0
                },
                last: function(x, w, e, y) {
                    return w === y.length - 1
                },
                even: function(w, e) {
                    return e % 2 === 0
                },
                odd: function(w, e) {
                    return e % 2 === 1
                },
                lt: function(x, w, e) {
                    return w < e[3] - 0
                },
                gt: function(x, w, e) {
                    return w > e[3] - 0
                },
                nth: function(x, w, e) {
                    return e[3] - 0 === w
                },
                eq: function(x, w, e) {
                    return e[3] - 0 === w
                }
            },
            filter: {
                PSEUDO: function(x, C, B, D) {
                    var e = C[1],
                    w = h.filters[e];
                    if (w) {
                        return w(x, B, C, D)
                    } else {
                        if (e === "contains") {
                            return (x.textContent || x.innerText || d.getText([x]) || "").indexOf(C[3]) >= 0
                        } else {
                            if (e === "not") {
                                var y = C[3];
                                for (var A = 0,
                                z = y.length; A < z; A++) {
                                    if (y[A] === x) {
                                        return false
                                    }
                                }
                                return true
                            } else {
                                d.error("Syntax error, unrecognized expression: " + e)
                            }
                        }
                    }
                },
                CHILD: function(e, y) {
                    var B = y[1],
                    w = e;
                    switch (B) {
                    case "only":
                    case "first":
                        while ((w = w.previousSibling)) {
                            if (w.nodeType === 1) {
                                return false
                            }
                        }
                        if (B === "first") {
                            return true
                        }
                        w = e;
                    case "last":
                        while ((w = w.nextSibling)) {
                            if (w.nodeType === 1) {
                                return false
                            }
                        }
                        return true;
                    case "nth":
                        var x = y[2],
                        E = y[3];
                        if (x === 1 && E === 0) {
                            return true
                        }
                        var A = y[0],
                        D = e.parentNode;
                        if (D && (D.sizcache !== A || !e.nodeIndex)) {
                            var z = 0;
                            for (w = D.firstChild; w; w = w.nextSibling) {
                                if (w.nodeType === 1) {
                                    w.nodeIndex = ++z
                                }
                            }
                            D.sizcache = A
                        }
                        var C = e.nodeIndex - E;
                        if (x === 0) {
                            return C === 0
                        } else {
                            return (C % x === 0 && C / x >= 0)
                        }
                    }
                },
                ID: function(w, e) {
                    return w.nodeType === 1 && w.getAttribute("id") === e
                },
                TAG: function(w, e) {
                    return (e === "*" && w.nodeType === 1) || w.nodeName.toLowerCase() === e
                },
                CLASS: function(w, e) {
                    return (" " + (w.className || w.getAttribute("class")) + " ").indexOf(e) > -1
                },
                ATTR: function(A, y) {
                    var x = y[1],
                    e = h.attrHandle[x] ? h.attrHandle[x](A) : A[x] != null ? A[x] : A.getAttribute(x),
                    B = e + "",
                    z = y[2],
                    w = y[4];
                    return e == null ? z === "!=": z === "=" ? B === w: z === "*=" ? B.indexOf(w) >= 0 : z === "~=" ? (" " + B + " ").indexOf(w) >= 0 : !w ? B && e !== false: z === "!=" ? B !== w: z === "^=" ? B.indexOf(w) === 0 : z === "$=" ? B.substr(B.length - w.length) === w: z === "|=" ? B === w || B.substr(0, w.length + 1) === w + "-": false
                },
                POS: function(z, w, x, A) {
                    var e = w[2],
                    y = h.setFilters[e];
                    if (y) {
                        return y(z, x, w, A)
                    }
                }
            }
        };
        d.selectors = h;
        var p = h.match.POS,
        i = function(w, e) {
            return "\\" + (e - 0 + 1)
        };
        for (var r in h.match) {
            h.match[r] = new RegExp(h.match[r].source + (/(?![^\[]*\])(?![^\(]*\))/.source));
            h.leftMatch[r] = new RegExp(/(^(?:.|\r|\n)*?)/.source + h.match[r].source.replace(/\\(\d+)/g, i))
        }
        var c = function(w, e) {
            w = Array.prototype.slice.call(w, 0);
            if (e) {
                e.push.apply(e, w);
                return e
            }
            return w
        };
        try {
            Array.prototype.slice.call(document.documentElement.childNodes, 0)[0].nodeType
        } catch(q) {
            c = function(z, y) {
                var w = y || [],
                x = 0;
                if (g.call(z) === "[object Array]") {
                    Array.prototype.push.apply(w, z)
                } else {
                    if (typeof z.length === "number") {
                        for (var e = z.length; x < e; x++) {
                            w.push(z[x])
                        }
                    } else {
                        for (; z[x]; x++) {
                            w.push(z[x])
                        }
                    }
                }
                return w
            }
        }
        var f;
        if (document.documentElement.compareDocumentPosition) {
            f = function(w, e) {
                if (!w.compareDocumentPosition || !e.compareDocumentPosition) {
                    if (w == e) {
                        t = true
                    }
                    return w.compareDocumentPosition ? -1 : 1
                }
                var x = w.compareDocumentPosition(e) & 4 ? -1 : w === e ? 0 : 1;
                if (x === 0) {
                    t = true
                }
                return x
            }
        } else {
            if ("sourceIndex" in document.documentElement) {
                f = function(w, e) {
                    if (!w.sourceIndex || !e.sourceIndex) {
                        if (w == e) {
                            t = true
                        }
                        return w.sourceIndex ? -1 : 1
                    }
                    var x = w.sourceIndex - e.sourceIndex;
                    if (x === 0) {
                        t = true
                    }
                    return x
                }
            } else {
                if (document.createRange) {
                    f = function(y, w) {
                        if (!y.ownerDocument || !w.ownerDocument) {
                            if (y == w) {
                                t = true
                            }
                            return y.ownerDocument ? -1 : 1
                        }
                        var x = y.ownerDocument.createRange(),
                        e = w.ownerDocument.createRange();
                        x.setStart(y, 0);
                        x.setEnd(y, 0);
                        e.setStart(w, 0);
                        e.setEnd(w, 0);
                        var z = x.compareBoundaryPoints(Range.START_TO_END, e);
                        if (z === 0) {
                            t = true
                        }
                        return z
                    }
                }
            }
        }
        d.getText = function(e) {
            var w = "",
            y;
            for (var x = 0; e[x]; x++) {
                y = e[x];
                if (y.nodeType === 3 || y.nodeType === 4) {
                    w += y.nodeValue
                } else {
                    if (y.nodeType !== 8) {
                        w += d.getText(y.childNodes)
                    }
                }
            }
            return w
        }; (function() {
            var w = document.createElement("div"),
            x = "script" + (new Date()).getTime();
            w.innerHTML = "<a name='" + x + "'/>";
            var e = document.documentElement;
            e.insertBefore(w, e.firstChild);
            if (document.getElementById(x)) {
                h.find.ID = function(z, A, B) {
                    if (typeof A.getElementById !== "undefined" && !B) {
                        var y = A.getElementById(z[1]);
                        return y ? y.id === z[1] || typeof y.getAttributeNode !== "undefined" && y.getAttributeNode("id").nodeValue === z[1] ? [y] : undefined: []
                    }
                };
                h.filter.ID = function(A, y) {
                    var z = typeof A.getAttributeNode !== "undefined" && A.getAttributeNode("id");
                    return A.nodeType === 1 && z && z.nodeValue === y
                }
            }
            e.removeChild(w);
            e = w = null
        })(); (function() {
            var e = document.createElement("div");
            e.appendChild(document.createComment(""));
            if (e.getElementsByTagName("*").length > 0) {
                h.find.TAG = function(w, A) {
                    var z = A.getElementsByTagName(w[1]);
                    if (w[1] === "*") {
                        var y = [];
                        for (var x = 0; z[x]; x++) {
                            if (z[x].nodeType === 1) {
                                y.push(z[x])
                            }
                        }
                        z = y
                    }
                    return z
                }
            }
            e.innerHTML = "<a href='#'></a>";
            if (e.firstChild && typeof e.firstChild.getAttribute !== "undefined" && e.firstChild.getAttribute("href") !== "#") {
                h.attrHandle.href = function(w) {
                    return w.getAttribute("href", 2)
                }
            }
            e = null
        })();
        if (document.querySelectorAll) { (function() {
                var e = d,
                x = document.createElement("div");
                x.innerHTML = "<p class='TEST'></p>";
                if (x.querySelectorAll && x.querySelectorAll(".TEST").length === 0) {
                    return
                }
                d = function(B, A, y, z) {
                    A = A || document;
                    if (!z && A.nodeType === 9 && !d.isXML(A)) {
                        try {
                            return c(A.querySelectorAll(B), y)
                        } catch(C) {}
                    }
                    return e(B, A, y, z)
                };
                for (var w in e) {
                    d[w] = e[w]
                }
                x = null
            })()
        } (function() {
            var e = document.createElement("div");
            e.innerHTML = "<div class='test e'></div><div class='test'></div>";
            if (!e.getElementsByClassName || e.getElementsByClassName("e").length === 0) {
                return
            }
            e.lastChild.className = "e";
            if (e.getElementsByClassName("e").length === 1) {
                return
            }
            h.order.splice(1, 0, "CLASS");
            h.find.CLASS = function(w, x, y) {
                if (typeof x.getElementsByClassName !== "undefined" && !y) {
                    return x.getElementsByClassName(w[1])
                }
            };
            e = null
        })();
        function s(w, B, A, E, C, D) {
            for (var y = 0,
            x = E.length; y < x; y++) {
                var e = E[y];
                if (e) {
                    e = e[w];
                    var z = false;
                    while (e) {
                        if (e.sizcache === A) {
                            z = E[e.sizset];
                            break
                        }
                        if (e.nodeType === 1 && !D) {
                            e.sizcache = A;
                            e.sizset = y
                        }
                        if (e.nodeName.toLowerCase() === B) {
                            z = e;
                            break
                        }
                        e = e[w]
                    }
                    E[y] = z
                }
            }
        }
        function v(w, B, A, E, C, D) {
            for (var y = 0,
            x = E.length; y < x; y++) {
                var e = E[y];
                if (e) {
                    e = e[w];
                    var z = false;
                    while (e) {
                        if (e.sizcache === A) {
                            z = E[e.sizset];
                            break
                        }
                        if (e.nodeType === 1) {
                            if (!D) {
                                e.sizcache = A;
                                e.sizset = y
                            }
                            if (typeof B !== "string") {
                                if (e === B) {
                                    z = true;
                                    break
                                }
                            } else {
                                if (d.filter(B, [e]).length > 0) {
                                    z = e;
                                    break
                                }
                            }
                        }
                        e = e[w]
                    }
                    E[y] = z
                }
            }
        }
        d.contains = document.compareDocumentPosition ?
        function(w, e) {
            return !! (w.compareDocumentPosition(e) & 16)
        }: function(w, e) {
            return w !== e && (w.contains ? w.contains(e) : true)
        };
        d.isXML = function(e) {
            var w = (e ? e.ownerDocument || e: 0).documentElement;
            return w ? w.nodeName !== "HTML": false
        };
        var j = function(e, C) {
            var y = [],
            z = "",
            A,
            x = C.nodeType ? [C] : C;
            while ((A = h.match.PSEUDO.exec(e))) {
                z += A[0];
                e = e.replace(h.match.PSEUDO, "")
            }
            e = h.relative[e] ? e + "*": e;
            for (var B = 0,
            w = x.length; B < w; B++) {
                d(e, x[B], y)
            }
            return d.filter(z, y)
        };
        return d
    });
    a.register("core.dom.contains",
    function(c) {
        return function(d, e) {
            if (d === e) {
                return false
            } else {
                if (d.compareDocumentPosition) {
                    return ((d.compareDocumentPosition(e) & 16) === 16)
                } else {
                    if (d.contains && e.nodeType === 1) {
                        return d.contains(e)
                    } else {
                        while (e = e.parentNode) {
                            if (d === e) {
                                return true
                            }
                        }
                    }
                }
            }
            return false
        }
    });
    a.register("core.evt.removeEvent",
    function(c) {
        return function(e, g, f, d) {
            var h = c.E(e);
            if (h == null) {
                return false
            }
            if (typeof f != "function") {
                return false
            }
            if (h.removeEventListener) {
                h.removeEventListener(g, f, d)
            } else {
                if (h.detachEvent) {
                    h.detachEvent("on" + g, f)
                } else {
                    h["on" + g] = null
                }
            }
            return true
        }
    });
    a.register("core.evt.fixEvent",
    function(c) {
        return function(d) {
            d = d || c.core.evt.getEvent();
            if (!d.target) {
                d.target = d.srcElement;
                d.pageX = d.x;
                d.pageY = d.y
            }
            if (typeof d.layerX == "undefined") {
                d.layerX = d.offsetX
            }
            if (typeof d.layerY == "undefined") {
                d.layerY = d.offsetY
            }
            return d
        }
    });
    a.register("core.obj.isEmpty",
    function(c) {
        return function(g, f) {
            var e = true;
            for (var d in g) {
                if (f) {
                    e = false;
                    break
                } else {
                    if (g.hasOwnProperty(d)) {
                        e = false;
                        break
                    }
                }
            }
            return e
        }
    });
    a.register("core.func.empty",
    function() {
        return function() {}
    });
    a.register("core.evt.delegatedEvent",
    function(d) {
        var c = function(h, g) {
            for (var f = 0,
            e = h.length; f < e; f += 1) {
                if (d.core.dom.contains(h[f], g)) {
                    return true
                }
            }
            return false
        };
        return function(f, i) {
            if (!d.core.dom.isNode(f)) {
                throw "core.evt.delegatedEvent need an Element as first Parameter"
            }
            if (!i) {
                i = []
            }
            if (d.core.arr.isArray(i)) {
                i = [i]
            }
            var e = {};
            var h = function(q) {
                var m = d.core.evt.fixEvent(q);
                var p = m.target;
                var o = q.type;
                var r = function() {
                    var u, s, t;
                    u = p.getAttribute("action-target");
                    if (u) {
                        s = d.core.dom.sizzle(u, f);
                        if (s.length) {
                            t = m.target = s[0]
                        }
                    }
                    r = d.core.func.empty;
                    return t
                };
                var j = function() {
                    var s = r() || p;
                    if (e[o] && e[o][n]) {
                        return e[o][n]({
                            evt: m,
                            el: s,
                            box: f,
                            data: d.core.json.queryToJson(s.getAttribute("action-data") || "")
                        })
                    } else {
                        return true
                    }
                };
                if (c(i, p)) {
                    return false
                } else {
                    if (!d.core.dom.contains(f, p)) {
                        return false
                    } else {
                        var n = null;
                        while (p && p !== f) {
                            n = p.getAttribute("action-type");
                            if (n && j() === false) {
                                break
                            }
                            p = p.parentNode
                        }
                    }
                }
            };
            var g = {};
            g.add = function(n, o, m) {
                if (!e[o]) {
                    e[o] = {};
                    d.core.evt.addEvent(f, o, h)
                }
                var j = e[o];
                j[n] = m
            };
            g.remove = function(j, m) {
                if (e[m]) {
                    delete e[m][j];
                    if (d.core.obj.isEmpty(e[m])) {
                        delete e[m];
                        d.core.evt.removeEvent(f, m, h)
                    }
                }
            };
            g.pushExcept = function(j) {
                i.push(j)
            };
            g.removeExcept = function(n) {
                if (!n) {
                    i = []
                } else {
                    for (var m = 0,
                    j = i.length; m < j; m += 1) {
                        if (i[m] === n) {
                            i.splice(m, 1)
                        }
                    }
                }
            };
            g.clearExcept = function(j) {
                i = []
            };
            g.destroy = function() {
                for (k in e) {
                    for (l in e[k]) {
                        delete e[k][l]
                    }
                    delete e[k];
                    d.core.evt.removeEvent(f, k, h)
                }
            };
            return g
        }
    });
    a.register("core.evt.custEvent",
    function(e) {
        var c = "__custEventKey__",
        f = 1,
        g = {},
        d = function(j, i) {
            var h = (typeof j == "number") ? j: j[c];
            return (h && g[h]) && {
                obj: (typeof i == "string" ? g[h][i] : g[h]),
                key: h
            }
        };
        return {
            define: function(o, m) {
                if (o && m) {
                    var j = (typeof o == "number") ? o: o[c] || (o[c] = f++),
                    n = g[j] || (g[j] = {});
                    m = [].concat(m);
                    for (var h = 0; h < m.length; h++) {
                        n[m[h]] || (n[m[h]] = [])
                    }
                    return j
                }
            },
            undefine: function(n, m) {
                if (n) {
                    var j = (typeof n == "number") ? n: n[c];
                    if (j && g[j]) {
                        if (m) {
                            m = [].concat(m);
                            for (var h = 0; h < m.length; h++) {
                                if (m[h] in g[j]) {
                                    delete g[j][m[h]]
                                }
                            }
                        } else {
                            delete g[j]
                        }
                    }
                }
            },
            add: function(n, i, h, j) {
                if (n && typeof i == "string" && h) {
                    var m = d(n, i);
                    if (!m || !m.obj) {
                        throw "custEvent (" + i + ") is undefined !"
                    }
                    m.obj.push({
                        fn: h,
                        data: j
                    });
                    return m.key
                }
            },
            once: function(n, i, h, j) {
                if (n && typeof i == "string" && h) {
                    var m = d(n, i);
                    if (!m || !m.obj) {
                        throw "custEvent (" + i + ") is undefined !"
                    }
                    m.obj.push({
                        fn: h,
                        data: j,
                        once: true
                    });
                    return m.key
                }
            },
            remove: function(p, n, m) {
                if (p) {
                    var o = d(p, n),
                    q,
                    h;
                    if (o && (q = o.obj)) {
                        if (e.core.arr.isArray(q)) {
                            if (m) {
                                var j = 0;
                                while (q[j]) {
                                    if (q[j].fn === m) {
                                        break
                                    }
                                    j++
                                }
                                q.splice(j, 1)
                            } else {
                                q.splice(0, q.length)
                            }
                        } else {
                            for (var j in q) {
                                q[j] = []
                            }
                        }
                        return o.key
                    }
                }
            },
            fire: function(j, r, p) {
                if (j && typeof r == "string") {
                    var h = d(j, r),
                    o;
                    if (h && (o = h.obj)) {
                        if (!e.core.arr.isArray(p)) {
                            p = p != undefined ? [p] : []
                        }
                        for (var m = o.length - 1; m > -1 && o[m]; m--) {
                            var s = o[m].fn;
                            var q = o[m].once;
                            if (s && s.apply) {
                                try {
                                    s.apply(j, [{
                                        type: r,
                                        data: o[m].data
                                    }].concat(p));
                                    if (q) {
                                        o.splice(m, 1)
                                    }
                                } catch(n) {
                                    e.log("[error][custEvent]" + n.message)
                                }
                            }
                        }
                        return h.key
                    }
                }
            },
            destroy: function() {
                g = {};
                f = 1
            }
        }
    });
    a.register("core.obj.parseParam",
    function(c) {
        return function(f, e, d) {
            var g, h = {};
            e = e || {};
            for (g in f) {
                h[g] = f[g];
                if (e[g] != null) {
                    if (d) {
                        if (f.hasOwnProperty[g]) {
                            h[g] = e[g]
                        }
                    } else {
                        h[g] = e[g]
                    }
                }
            }
            return h
        }
    });
    a.register("core.arr.indexOf",
    function(c) {
        return function(f, g) {
            if (g.indexOf) {
                return g.indexOf(f)
            }
            for (var e = 0,
            d = g.length; e < d; e++) {
                if (g[e] === f) {
                    return e
                }
            }
            return - 1
        }
    });
    a.register("core.arr.inArray",
    function(c) {
        return function(d, e) {
            return c.core.arr.indexOf(d, e) > -1
        }
    });
    a.register("core.json.merge",
    function(d) {
        var c = function(f) {
            if (f === undefined) {
                return true
            }
            if (f === null) {
                return true
            }
            if (d.core.arr.inArray(["number", "string", "function"], (typeof f))) {
                return true
            }
            if (d.core.arr.isArray(f)) {
                return true
            }
            if (d.core.dom.isNode(f)) {
                return true
            }
            return false
        };
        var e = function(i, m, h) {
            var j = {};
            for (var g in i) {
                if (m[g] === undefined) {
                    j[g] = i[g]
                } else {
                    if (!c(i[g]) && !c(m[g]) && h) {
                        j[g] = arguments.callee(i[g], m[g])
                    } else {
                        j[g] = m[g]
                    }
                }
            }
            for (var f in m) {
                if (j[f] === undefined) {
                    j[f] = m[f]
                }
            }
            return j
        };
        return function(f, i, h) {
            var g = d.core.obj.parseParam({
                isDeep: false
            },
            h);
            return e(f, i, g.isDeep)
        }
    });
    a.register("core.json.jsonToQuery",
    function(c) {
        var d = function(f, e) {
            f = f == null ? "": f;
            f = c.core.str.trim(f.toString());
            if (e) {
                return encodeURIComponent(f)
            } else {
                return f
            }
        };
        return function(j, g) {
            var m = [];
            if (typeof j == "object") {
                for (var f in j) {
                    if (f === "$nullName") {
                        m = m.concat(j[f]);
                        continue
                    }
                    if (j[f] instanceof Array) {
                        for (var h = 0,
                        e = j[f].length; h < e; h++) {
                            m.push(f + "=" + d(j[f][h], g))
                        }
                    } else {
                        if (typeof j[f] != "function") {
                            m.push(f + "=" + d(j[f], g))
                        }
                    }
                }
            }
            if (m.length) {
                return m.join("&")
            } else {
                return ""
            }
        }
    });
    a.register("core.util.scrollPos",
    function(c) {
        return function(f) {
            f = f || document;
            var d = f.documentElement;
            var e = f.body;
            return {
                top: Math.max(window.pageYOffset || 0, d.scrollTop, e.scrollTop),
                left: Math.max(window.pageXOffset || 0, d.scrollLeft, e.scrollLeft)
            }
        }
    });
    a.register("core.util.winSize",
    function(c) {
        return function(e) {
            var d, f;
            var g;
            if (e) {
                g = e.document
            } else {
                g = document
            }
            if (g.compatMode === "CSS1Compat") {
                d = g.documentElement.clientWidth;
                f = g.documentElement.clientHeight
            } else {
                if (self.innerHeight) {
                    if (e) {
                        g = e.self
                    } else {
                        g = self
                    }
                    d = g.innerWidth;
                    f = g.innerHeight
                } else {
                    if (g.documentElement && g.documentElement.clientHeight) {
                        d = g.documentElement.clientWidth;
                        f = g.documentElement.clientHeight
                    } else {
                        if (g.body) {
                            d = g.body.clientWidth;
                            f = g.body.clientHeight
                        }
                    }
                }
            }
            return {
                width: d,
                height: f
            }
        }
    });
    a.register("core.util.pageSize",
    function(c) {
        return function(f) {
            if (f) {
                target = f.document
            } else {
                target = document
            }
            var j = (target.compatMode == "CSS1Compat" ? target.documentElement: target.body);
            var i, e;
            var h, g;
            if (window.innerHeight && window.scrollMaxY) {
                i = j.scrollWidth;
                e = window.innerHeight + window.scrollMaxY
            } else {
                if (j.scrollHeight > j.offsetHeight) {
                    i = j.scrollWidth;
                    e = j.scrollHeight
                } else {
                    i = j.offsetWidth;
                    e = j.offsetHeight
                }
            }
            var d = c.core.util.winSize(f);
            if (e < d.height) {
                h = d.height
            } else {
                h = e
            }
            if (i < d.width) {
                g = d.width
            } else {
                g = i
            }
            return {
                page: {
                    width: g,
                    height: h
                },
                win: {
                    width: d.width,
                    height: d.height
                }
            }
        }
    });
    a.register("core.util.getUniqueKey",
    function(e) {
        var c = (new Date()).getTime().toString(),
        d = 1;
        return function() {
            return c + (d++)
        }
    });
    a.register("kit.dom.layoutPos",
    function(c) {
        return function(g, e, d) {
            if (!c.isNode(e)) {
                throw "kit.dom.layerOutElement need element as first parameter"
            }
            if (e === document.body) {
                return false
            }
            if (!e.parentNode) {
                return false
            }
            if (e.style.display === "none") {
                return false
            }
            var i, h, m, o, j, n, f;
            i = c.parseParam({
                pos: "left-bottom",
                offsetX: 0,
                offsetY: 0
            },
            d);
            h = e;
            if (!h) {
                return false
            }
            while (h !== document.body) {
                h = h.parentNode;
                if (h.style.display === "none") {
                    return false
                }
                n = c.getStyle(h, "position");
                f = h.getAttribute("layout-shell");
                if (n === "absolute" || n === "fixed") {
                    break
                }
                if (f === "true" && n === "relative") {
                    break
                }
            }
            h.appendChild(g);
            m = c.position(e, {
                parent: h
            });
            o = {
                w: e.offsetWidth,
                h: e.offsetHeight
            };
            j = i.pos.split("-");
            if (j[0] === "left") {
                g.style.left = m.l + i.offsetX + "px"
            } else {
                if (j[0] === "right") {
                    g.style.left = m.l + o.w + i.offsetX + "px"
                } else {
                    if (j[0] === "center") {
                        g.style.left = m.l + o.w / 2 + i.offsetX + "px"
                    }
                }
            }
            if (j[1] === "top") {
                g.style.top = m.t + i.offsetY + "px"
            } else {
                if (j[1] === "bottom") {
                    g.style.top = m.t + o.h + i.offsetY + "px"
                } else {
                    if (j[1] === "middle") {
                        g.style.top = m.t + o.h / 2 + i.offsetY + "px"
                    }
                }
            }
            return true
        }
    });
    a.register("core.util.hideContainer",
    function(e) {
        var f;
        var c = function() {
            if (f) {
                return
            }
            f = e.C("div");
            f.style.cssText = "position:absolute;top:-9999px;left:-9999px;";
            document.getElementsByTagName("head")[0].appendChild(f)
        };
        var d = {
            appendChild: function(g) {
                if (e.core.dom.isNode(g)) {
                    c();
                    f.appendChild(g)
                }
            },
            removeChild: function(g) {
                if (e.core.dom.isNode(g)) {
                    f && f.removeChild(g)
                }
            }
        };
        return d
    });
    a.register("core.dom.getSize",
    function(d) {
        var c = function(f) {
            if (!d.core.dom.isNode(f)) {
                throw "core.dom.getSize need Element as first parameter"
            }
            return {
                width: f.offsetWidth,
                height: f.offsetHeight
            }
        };
        var e = function(g) {
            var f = null;
            if (g.style.display === "none") {
                g.style.visibility = "hidden";
                g.style.display = "";
                f = c(g);
                g.style.display = "none";
                g.style.visibility = "visible"
            } else {
                f = c(g)
            }
            return f
        };
        return function(g) {
            var f = {};
            if (!g.parentNode) {
                d.core.util.hideContainer.appendChild(g);
                f = e(g);
                d.core.util.hideContainer.removeChild(g)
            } else {
                f = e(g)
            }
            return f
        }
    });
    var b = a;
    b.isNode = b.core.dom.isNode;
    b.parseParam = b.core.obj.parseParam;
    b.getStyle = b.core.dom.getStyle;
    b.position = b.core.dom.position;
    b.addEvent = b.core.evt.addEvent;
    b.custEvent = b.core.evt.custEvent;
    b.removeEvent = b.core.evt.removeEvent;
    b.getSize = b.core.dom.getSize;
    a.register("common.appframe.dataTransfer",
    function(c) {
        return function(n) {
            var g = {};
            var m;
            var h;
            var f = 0;
            var w = c.core.json.queryToJson;
            var j = c.core.json.jsonToQuery;
            var e = c.core.json.merge;
            c.custEvent.define(g, "message");
            var d = function(z) {
                z = z || window.event;
                var A = unescape(z.data);
                var x = w(A);
                for (var y in x) {
                    if (!isNaN(x[y])) {
                        x[y] = (x[y] == "") ? 0 : parseInt(x[y])
                    }
                    if (x[y] == "true" || x[y] == "false") {
                        x[y] = x[y] == "true"
                    }
                }
                c.custEvent.fire(g, "message", x)
            };
            g.sendMessage = function(y, x) {
                if (x) {
                    y.inner = x
                }
                var z = j(y);
                z = escape(z);
                var A = n.node ? n.node.contentWindow: window.parent;
                if (window.postMessage) {
                    A.postMessage(z, "*")
                } else {
                    A.name = (new Date()).getTime() + (f++) + "^" + document.domain + "&" + window.escape(z)
                }
            };
            var v = function(x, C) {
                var B = "";
                var A = "";
                function y(D) {
                    var E = D.split("^").pop().split("&");
                    return {
                        domain: E[0],
                        data: window.unescape(E[1])
                    }
                }
                function z() {
                    var D = x[C];
                    var E = y(D);
                    if (w(unescape(E.data)).inner) {
                        if (D == A) {
                            return
                        }
                        A = D;
                        d(E)
                    } else {
                        if (D != B) {
                            B = D;
                            d(E)
                        }
                    }
                }
                m = setInterval(z, 1000 / 20)
            };
            var q = function() {
                if (window.postMessage) {
                    c.addEvent(window, "message", d)
                } else {
                    v(window, "name")
                }
            };
            var p = function() {
                h = e({},
                n)
            };
            var o = {};
            var r = function(x, y) {
                if (!o[x]) {
                    o[x] = []
                }
                o[x] = o[x].concat(y)
            };
            var i = function(B, y) {
                var x = o[B];
                for (var A = 0; A < x.length; A++) {
                    var z = x[A];
                    if (z == y) {
                        x.splice(A, 1)
                    }
                }
            };
            var t = function(B, y) {
                if (!B) {
                    for (var A in o) {
                        o[A] = []
                    }
                } else {
                    if (!y) {
                        o[B] = []
                    } else {
                        y = [].concat(y);
                        for (var z = 0; z < y.length; z++) {
                            var x = y[z];
                            i(B, x)
                        }
                    }
                }
            };
            g.define = function(x) {
                r(x, {
                    reg: true
                })
            };
            g.undefine = function(x) {
                t(x)
            };
            g.fireEvent = function(B, C) {
                var y = o[B];
                if (!y) {
                    return
                }
                if (y.length == 1 && y[0].reg) {
                    var A = C;
                    A.type = B;
                    A.reg = true;
                    g.sendMessage(A, true);
                    return
                }
                for (var z = 0; z < y.length; z++) {
                    var x = y[z];
                    x.apply(this, [{
                        type: B
                    },
                    C])
                }
            };
            g.addEvent = r;
            g.removeEvent = t;
            var u = function() {
                clearInterval(m);
                m = null;
                c.custEvent.undefine(g, "message");
                c.removeEvent(window, "message")
            };
            var s = function() {
                p();
                q()
            };
            s();
            g.destroy = u;
            return g
        }
    });
    a.register("common.appframe.client",
    function(c) {
        return function(e) {
            var m = {};
            var h;
            var n;
            var s;
            var q, u;
            var p = c.core.json.merge;
            c.custEvent.define(m, ["message", "scroll"]);
            var o = function() {
                if (!e) {
                    e = {}
                }
                n = p({
                    scroll: true
                },
                e)
            };
            var v;
            var g = function() {
                var x = c.getSize(document.body);
                var z = x.width;
                var w = x.height;
                if (z == q && w == u) {
                    return
                }
                q = z;
                u = w;
                var y = {
                    height: u
                };
                s.sendMessage(y, true)
            };
            m.sendMessage = function(w) {
                s.sendMessage(w);
                return m
            };
            m.unLogin = function() {
                s.sendMessage({
                    unLogin: true
                },
                true);
                return m
            };
            var j = function(w, y) {
                if (!y.inner) {
                    s.fireEvent("message", y)
                } else {
                    if (y.reg) {
                        var x = y.type;
                        delete y.type;
                        s.fireEvent(x, y)
                    }
                }
                if (y.scroll) {
                    delete y.inner;
                    delete y.scroll;
                    s.fireEvent("scroll", y)
                }
                if (y.init) {
                    clearInterval(h);
                    h = null;
                    s.sendMessage({
                        init: true
                    },
                    true);
                    setTimeout(d, 500)
                }
            };
            var i = function() {
                s = c.common.appframe.dataTransfer({
                    type: "client"
                });
                m.addEvent = s.addEvent;
                m.removeEvent = s.removeEvent;
                m.fireEvent = s.fireEvent;
                m.define = s.define
            };
            var f = function() {
                c.custEvent.add(s, "message", j)
            };
            var d = function() {
                h = setInterval(g, 500)
            };
            var t = function() {
                o();
                d();
                i();
                f();
                s.sendMessage({
                    init: true
                },
                true)
            };
            var r = function() {
                clearInterval(h);
                h = null;
                c.custEvent.remove(s, "message");
                s.destroy();
                c.custEvent.undefine(m, ["message", "scroll"]);
                m.sendMessage = c.core.func.empty
            };
            if (window.parent !== window.self) {
                t()
            }
            m.destroy = r;
            return m
        }
    }); (function() {
        var j = (function() {
            var u = window.localStorage,
            v, w;
            if (u) {
                return {
                    get: function(y) {
                        return unescape(u.getItem(y))
                    },
                    set: function(y, z) {
                        u.setItem(y, escape(z))
                    }
                }
            } else {
                if (window.ActiveXObject) {
                    v = document.documentElement;
                    w = "localstorage";
                    try {
                        v.addBehavior("#default#userdata");
                        v.save("localstorage")
                    } catch(x) {}
                    return {
                        set: function(y, z) {
                            try {
                                v.setAttribute(y, z);
                                v.save(w)
                            } catch(A) {}
                        },
                        get: function(y) {
                            try {
                                v.load(w);
                                return v.getAttribute(y)
                            } catch(z) {}
                        }
                    }
                } else {
                    return {
                        get: function(C) {
                            var A = document.cookie.split("; "),
                            z = A.length,
                            y = [];
                            for (var B = 0; B < z; B++) {
                                y = A[B].split("=");
                                if (C === y[0]) {
                                    return unescape(y[1])
                                }
                            }
                            return null
                        },
                        set: function(y, z, A) {
                            if (! (A && typeof A === date)) {
                                A = new Date();
                                A.setDate(A.getDate() + 1)
                            }
                            document.cookie = y + "=" + escape(z) + "; expires=" + A.toGMTString()
                        },
                        del: function(y) {
                            document.cookie = y + "=''; expires=Fri, 31 Dec 1999 23:59:59 GMT;"
                        },
                        clear: function() {
                            var A = document.cookie.split(";"),
                            z = A.length,
                            y = [];
                            for (var B = 0; B < z; B++) {
                                y = A[B].split("=");
                                this.deleteKey(y[0])
                            }
                        },
                        getAll: function() {
                            return unescape(document.cookie.toString())
                        }
                    }
                }
            }
        })();
        var n = navigator.userAgent,
        f = /msie/i.test(n);
        var t = function() {};
        function s(w, v, u) {
            var x, y = {};
            v = v || {};
            for (x in w) {
                y[x] = w[x];
                if (v[x] != null) {
                    if (u) {
                        if (w.hasOwnProperty[x]) {
                            y[x] = v[x]
                        }
                    } else {
                        y[x] = v[x]
                    }
                }
            }
            return y
        }
        function d(u) {
            u = document.getElementById(u) || u;
            try {
                u.parentNode.removeChild(u)
            } catch(v) {}
        }
        function q(v) {
            if (v) {
                var u = [];
                for (var w in v) {
                    u.push(w + "=" + encodeURIComponent(v[w]))
                }
                if (u.length) {
                    return u.join("&")
                } else {
                    return ""
                }
            }
        }
        function m(C, A) {
            var y = {};
            var z = {
                url: "",
                charset: "UTF-8",
                timeout: 30 * 1000,
                args: {},
                onComplete: t,
                onTimeout: t,
                isEncode: false,
                uniqueID: null
            };
            var x, w;
            var v = s(z, C);
            if (v.url == "") {
                throw new Error("scriptLoader: url is null")
            }
            var u = v.uniqueID || (new Date().getTime().toString());
            x = y[u];
            if (x != null && f != true) {
                d(x);
                x = null
            }
            if (x == null) {
                y[u] = document.createElement("script");
                x = y[u]
            }
            x.charset = v.charset;
            x.type = "text/javascript";
            if (v.onComplete != null) {
                if (f) {
                    x.onreadystatechange = function() {
                        if (x.readyState.toLowerCase() == "loaded" || x.readyState.toLowerCase() == "complete") {
                            try {
                                clearTimeout(w);
                                document.getElementsByTagName("head")[0].removeChild(x);
                                x.onreadystatechange = null
                            } catch(D) {}
                            v.onComplete()
                        }
                    }
                } else {
                    x.onload = function() {
                        try {
                            clearTimeout(w);
                            d(x);
                            x.onload = null
                        } catch(D) {}
                        v.onComplete()
                    }
                }
            }
            var B = q(v.args);
            if (v.url.indexOf("?") == -1) {
                if (B != "") {
                    B = "?" + B
                }
            } else {
                if (B != "") {
                    B = "&" + B
                }
            }
            x.src = v.url + B;
            document.getElementsByTagName("head")[0].appendChild(x);
            if (v.timeout > 0 && v.onTimeout != null) {
                w = setTimeout(function() {
                    try {
                        document.getElementsByTagName("head")[0].removeChild(x)
                    } catch(D) {}
                    v.onTimeout()
                },
                v.timeout)
            }
            return x
        }
        function r() {
            m({
                url: "http://js.t.sinajs.cn/open/thirdpart/js/frame/version.js?" + (new Date()).getTime(),
                onComplete: function() {
                    var u = new Date();
                    i = u.getFullYear() + "/" + (u.getMonth() + 1) + "/" + u.getDate() + ":";
                    try {
                        i = i + $CONFIG.version.client.split(":")[1]
                    } catch(v) {
                        i = i + u.getTime()
                    }
                    p(i);
                    j.set("client", i)
                }
            })
        }
        function p(u) {
            var x = u.split(":");
            var w = new Date();
            var v = w.getFullYear() + "/" + (w.getMonth() + 1) + "/" + w.getDate();
            if (v != x[0]) {
                r()
            } else {
                h = x[1];
                g()
            }
        }
        var e;
        var c;
        var o = false;
        var i = j.get("client"),
        h;
        if (i == null || i == "null" || i.indexOf(":") == -1) {
            r()
        } else {
            p(i)
        }
        function g() {
            m({
                url: "http://js.t.sinajs.cn/open/thirdpart/js/frame/appauth.js??" + h,
                onComplete: function() {
                    if (e != null) {
                        App.AuthDialog.show(e)
                    }
                    if (c && isNaN(c) == false) {
                        App.setPageHeight(c)
                    }
                    if (o == true) {
                        App.scrollToTop()
                    }
                }
            })
        }
        if (window.App == null) {
            window.App = {
                AuthDialog: {
                    show: function(u) {
                        e = u
                    }
                },
                setPageHeight: function(u) {
                    if (u == null) {
                        c = document.body.clientHeight + 40
                    } else {
                        if (!isNaN(u)) {
                            c = u
                        }
                    }
                },
                scrollToTop: function() {
                    o = true
                }
            }
        }
    })();
    return b.common.appframe.client()
})();