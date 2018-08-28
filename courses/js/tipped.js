/*!
 * Tipped - A Complete Javascript Tooltip Solution - v4.2.8
 * (c) 2012-2015 Nick Stakenburg
 *
 * http://www.tippedjs.com
 *
 * License: http://www.tippedjs.com/license
 */
! function(a) {
    "function" == typeof define && define.amd ? define(["jquery"], a) : jQuery && !window.Tipped && (window.Tipped = a(jQuery))
}(function($) {
    function degrees(a) {
        return 180 * a / Math.PI
    }

    function radian(a) {
        return a * Math.PI / 180
    }

    function sec(a) {
        return 1 / Math.cos(a)
    }

    function sfcc(a) {
        return String.fromCharCode.apply(String, a.replace(" ", "").split(","))
    }

    function deepExtend(a, b) {
        for (var c in b) b[c] && b[c].constructor && b[c].constructor === Object ? (a[c] = $.extend({}, a[c]) || {}, deepExtend(a[c], b[c])) : a[c] = b[c];
        return a
    }

    function Spin() {
        return this.initialize.apply(this, _slice.call(arguments))
    }

    function Visible() {
        return this.initialize.apply(this, _slice.call(arguments))
    }

    function Skin() {
        this.initialize.apply(this, _slice.call(arguments))
    }

    function Stem() {
        this.initialize.apply(this, _slice.call(arguments))
    }

    function Tooltip() {
        this.initialize.apply(this, _slice.call(arguments))
    }

    function Collection(a) {
        this.element = a
    }
    var Tipped = window.Tipped || {};
    $.extend(Tipped, {
        version: "4.2.8"
    }), Tipped.Skins = {
        base: {
            afterUpdate: !1,
            ajax: {
                cache: !0
            },
            container: !1,
            containment: {
                selector: "viewport",
                padding: 5
            },
            close: !1,
            detach: !0,
            fadeIn: 200,
            fadeOut: 200,
            showDelay: 75,
            hideDelay: 25,
            hideAfter: !1,
            hideOn: {
                element: "mouseleave"
            },
            hideOthers: !1,
            position: "top",
            inline: !1,
            offset: {
                x: 0,
                y: 0
            },
            onHide: !1,
            onShow: !1,
            padding: !0,
            radius: !0,
            shadow: !0,
            showOn: {
                element: "mousemove"
            },
            size: "medium",
            spinner: !0,
            stem: !0,
            target: "element",
            voila: !0
        },
        reset: {
            ajax: !1,
            hideOn: {
                element: "mouseleave",
                tooltip: "mouseleave"
            },
            showOn: {
                element: "mouseenter",
                tooltip: "mouseenter"
            }
        }
    }, $.each("dark".split(" "), function(a, b) {
        Tipped.Skins[b] = {}
    });
    var Support = function() {
            function a(a) {
                return c(a, "prefix")
            }

            function b(a, b) {
                for (var c in a)
                    if (void 0 !== d.style[a[c]]) return "prefix" == b ? a[c] : !0;
                return !1
            }

            function c(a, c) {
                var d = a.charAt(0).toUpperCase() + a.substr(1),
                    f = (a + " " + e.join(d + " ") + d).split(" ");
                return b(f, c)
            }
            var d = document.createElement("div"),
                e = "Webkit Moz O ms Khtml".split(" ");
            return {
                css: {
                    animation: c("animation"),
                    transform: c("transform"),
                    prefixed: a
                },
                shadow: c("boxShadow") && c("pointerEvents"),
                touch: function() {
                    try {
                        return !!("ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch)
                    } catch (a) {
                        return !1
                    }
                }()
            }
        }(),
        Browser = function(a) {
            function b(b) {
                var c = new RegExp(b + "([\\d.]+)").exec(a);
                return c ? parseFloat(c[1]) : !0
            }
            return {
                IE: !(!window.attachEvent || -1 !== a.indexOf("Opera")) && b("MSIE "),
                Opera: a.indexOf("Opera") > -1 && (!!window.opera && opera.version && parseFloat(opera.version()) || 7.55),
                WebKit: a.indexOf("AppleWebKit/") > -1 && b("AppleWebKit/"),
                Gecko: a.indexOf("Gecko") > -1 && -1 === a.indexOf("KHTML") && b("rv:"),
                MobileSafari: !!a.match(/Apple.*Mobile.*Safari/),
                Chrome: a.indexOf("Chrome") > -1 && b("Chrome/"),
                ChromeMobile: a.indexOf("CrMo") > -1 && b("CrMo/"),
                Android: a.indexOf("Android") > -1 && b("Android "),
                IEMobile: a.indexOf("IEMobile") > -1 && b("IEMobile/")
            }
        }(navigator.userAgent),
        _slice = Array.prototype.slice,
        _ = {
            wrap: function(a, b) {
                var c = a;
                return function() {
                    var a = [$.proxy(c, this)].concat(_slice.call(arguments));
                    return b.apply(this, a)
                }
            },
            isElement: function(a) {
                return a && 1 == a.nodeType
            },
            delay: function(a, b) {
                var c = _slice.call(arguments, 2);
                return setTimeout(function() {
                    return a.apply(a, c)
                }, b)
            },
            defer: function(a) {
                return _.delay.apply(this, [a, 1].concat(_slice.call(arguments, 1)))
            },
            pointer: function(a) {
                return {
                    x: a.pageX,
                    y: a.pageY
                }
            },
            element: {
                isAttached: function() {
                    function a(a) {
                        for (var b = a; b && b.parentNode;) b = b.parentNode;
                        return b
                    }
                    return function(b) {
                        var c = a(b);
                        return !(!c || !c.body)
                    }
                }()
            }
        },
        getUID = function() {
            var a = 0,
                b = "_tipped-uid-";
            return function(c) {
                for (c = c || b, a++; document.getElementById(c + a);) a++;
                return c + a
            }
        }(),
        Position = {
            positions: ["topleft", "topmiddle", "topright", "righttop", "rightmiddle", "rightbottom", "bottomright", "bottommiddle", "bottomleft", "leftbottom", "leftmiddle", "lefttop"],
            regex: {
                toOrientation: /^(top|left|bottom|right)(top|left|bottom|right|middle|center)$/,
                horizontal: /^(top|bottom)/,
                isCenter: /(middle|center)/,
                side: /^(top|bottom|left|right)/
            },
            toDimension: function() {
                var a = {
                    top: "height",
                    left: "width",
                    bottom: "height",
                    right: "width"
                };
                return function(b) {
                    return a[b]
                }
            }(),
            isCenter: function(a) {
                return !!a.toLowerCase().match(this.regex.isCenter)
            },
            isCorner: function(a) {
                return !this.isCenter(a)
            },
            getOrientation: function(a) {
                return a.toLowerCase().match(this.regex.horizontal) ? "horizontal" : "vertical"
            },
            getSide: function(a) {
                var b = null,
                    c = a.toLowerCase().match(this.regex.side);
                return c && c[1] && (b = c[1]), b
            },
            split: function(a) {
                return a.toLowerCase().match(this.regex.toOrientation)
            },
            _flip: {
                top: "bottom",
                bottom: "top",
                left: "right",
                right: "left"
            },
            flip: function(a, b) {
                var c = this.split(a);
                return b ? this.inverseCornerPlane(this.flip(this.inverseCornerPlane(a))) : this._flip[c[1]] + c[2]
            },
            inverseCornerPlane: function(a) {
                if (Position.isCorner(a)) {
                    var b = this.split(a);
                    return b[2] + b[1]
                }
                return a
            },
            adjustOffsetBasedOnPosition: function(a, b, c) {
                var d = $.extend({}, a),
                    e = {
                        horizontal: "x",
                        vertical: "y"
                    },
                    f = {
                        x: "y",
                        y: "x"
                    },
                    g = {
                        top: {
                            right: "x"
                        },
                        bottom: {
                            left: "x"
                        },
                        left: {
                            bottom: "y"
                        },
                        right: {
                            top: "y"
                        }
                    },
                    h = Position.getOrientation(b);
                if (h == Position.getOrientation(c)) {
                    if (Position.getSide(b) != Position.getSide(c)) {
                        var i = f[e[h]];
                        d[i] *= -1
                    }
                } else {
                    var j = d.x;
                    d.x = d.y, d.y = j;
                    var k = g[Position.getSide(b)][Position.getSide(c)];
                    k && (d[k] *= -1), d[e[Position.getOrientation(c)]] = 0
                }
                return d
            },
            getBoxFromPoints: function(a, b, c, d) {
                var e = Math.min(a, c),
                    f = Math.max(a, c),
                    g = Math.min(b, d),
                    h = Math.max(b, d);
                return {
                    left: e,
                    top: g,
                    width: Math.max(f - e, 0),
                    height: Math.max(h - g, 0)
                }
            },
            isPointWithinBox: function(a, b, c, d, e, f) {
                var g = this.getBoxFromPoints(c, d, e, f);
                return a >= g.left && a <= g.left + g.width && b >= g.top && b <= g.top + g.height
            },
            isPointWithinBoxLayout: function(a, b, c) {
                return this.isPointWithinBox(a, b, c.position.left, c.position.top, c.position.left + c.dimensions.width, c.position.top + c.dimensions.height)
            },
            getDistance: function(a, b, c, d) {
                return Math.sqrt(Math.pow(Math.abs(c - a), 2) + Math.pow(Math.abs(d - b), 2))
            },
            intersectsLine: function() {
                var a = function(a, b, c, d, e, f) {
                    var g = (f - b) * (c - a) - (d - b) * (e - a);
                    return g > 0 ? !0 : 0 > g ? !1 : !0
                };
                return function(b, c, d, e, f, g, h, i, j) {
                    if (!j) return a(b, c, f, g, h, i) != a(d, e, f, g, h, i) && a(b, c, d, e, f, g) != a(b, c, d, e, h, i);
                    var k, l, m, n;
                    k = d - b, l = e - c, m = h - f, n = i - g;
                    var o, p;
                    if (o = (-l * (b - f) + k * (c - g)) / (-m * l + k * n), p = (m * (c - g) - n * (b - f)) / (-m * l + k * n), o >= 0 && 1 >= o && p >= 0 && 1 >= p) {
                        var q = b + p * k,
                            r = c + p * l;
                        return {
                            x: q,
                            y: r
                        }
                    }
                    return !1
                }
            }()
        },
        Bounds = {
            viewport: function() {
                var a;
                return a = Browser.MobileSafari || Browser.Android && Browser.Gecko ? {
                    width: window.innerWidth,
                    height: window.innerHeight
                } : {
                    height: $(window).height(),
                    width: $(window).width()
                }
            }
        },
        Mouse = {
            _buffer: {
                pageX: 0,
                pageY: 0
            },
            _dimensions: {
                width: 30,
                height: 30
            },
            _shift: {
                x: 2,
                y: 10
            },
            getPosition: function(a) {
                var b = a && "number" == $.type(a.pageX) ? a : this._buffer;
                return {
                    left: b.pageX - Math.round(.5 * this._dimensions.width) + this._shift.x,
                    top: b.pageY - Math.round(.5 * this._dimensions.height) + this._shift.y
                }
            },
            getDimensions: function() {
                return this._dimensions
            }
        },
        Color = function() {
            function a(a) {
                return ("0" + parseInt(a).toString(16)).slice(-2)
            }

            function b(b) {
                return b = b.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+))?\)$/), "#" + a(b[1]) + a(b[2]) + a(b[3])
            }
            var c = {
                _default: "#f26522",
                aqua: "#00ffff",
                black: "#000000",
                blue: "#0000ff",
                fuchsia: "#ff00ff",
                gray: "#808080",
                green: "#008000",
                lime: "#00ff00",
                maroon: "#800000",
                navy: "#000080",
                olive: "#808000",
                purple: "#800080",
                red: "#ff0000",
                silver: "#c0c0c0",
                teal: "#008080",
                white: "#ffffff",
                yellow: "#ffff00",
                orrange: "#f26522"
            };
            return {
                toRGB: function(a) {
                    if (/^rgba?\(/.test(a)) return b(a);
                    c[a] && (a = c[a]);
                    var d = a.replace("#", "");
                    return /^(?:[0-9a-fA-F]{3}){1,2}$/.test(d) || c._default, 3 == d.length && (d = d.charAt(0) + d.charAt(0) + d.charAt(1) + d.charAt(1) + d.charAt(2) + d.charAt(2)), "#" + d
                }
            }
        }();
    Spin.supported = Support.css.transform && Support.css.animation, $.extend(Spin.prototype, {
        initialize: function() {
            this.options = $.extend({}, arguments[0] || {}), this.build(), this.start()
        },
        build: function() {
            var a = 2 * (this.options.length + this.options.radius),
                b = {
                    height: a,
                    width: a
                };
            this.element = $("<div>").addClass("tpd-spin").css(b), this.element.append(this._rotate = $("<div>").addClass("tpd-spin-rotate")), this.element.css({
                "margin-left": -.5 * b.width,
                "margin-top": -.5 * b.height
            });
            for (var c = this.options.lines, d = 0; c > d; d++) {
                var e, f;
                this._rotate.append(e = $("<div>").addClass("tpd-spin-frame").append(f = $("<div>").addClass("tpd-spin-line"))), f.css({
                    "background-color": this.options.color,
                    width: this.options.width,
                    height: this.options.length,
                    "margin-left": -.5 * this.options.width,
                    "border-radius": Math.round(.5 * this.options.width)
                }), e.css({
                    opacity: (1 / c * (d + 1)).toFixed(2)
                });
                var g = {};
                g[Support.css.prefixed("transform")] = "rotate(" + 360 / c * (d + 1) + "deg)", e.css(g)
            }
        },
        start: function() {
            var a = {};
            a[Support.css.prefixed("animation")] = "tpd-spin 1s infinite steps(" + this.options.lines + ")", this._rotate.css(a)
        },
        stop: function() {
            var a = {};
            a[Support.css.prefixed("animation")] = "none", this._rotate.css(a), this.element.detach()
        }
    }), $.extend(Visible.prototype, {
        initialize: function(a) {
            return a = "array" == $.type(a) ? a : [a], this.elements = a, this._restore = [], $.each(a, $.proxy(function(a, b) {
                var c = $(b).is(":visible");
                c || $(b).show(), this._restore.push({
                    element: b,
                    visible: c
                })
            }, this)), this
        },
        restore: function() {
            $.each(this._restore, function(a, b) {
                b.visible || $(b.element).show()
            }), this._restore = null
        }
    });
    var AjaxCache = function() {
            var a = [];
            return {
                get: function(b) {
                    for (var c = null, d = 0; d < a.length; d++) a[d] && a[d].url == b.url && (a[d].type || "GET").toUpperCase() == (b.type || "GET").toUpperCase() && $.param(a[d].data || {}) == $.param(b.data || {}) && (c = a[d]);
                    return c
                },
                set: function(b, c, d) {
                    var e = this.get(b);
                    e || (e = $.extend({
                        callbacks: {}
                    }, b), a.push(e)), e.callbacks[c] = d
                },
                remove: function(b) {
                    for (var c = 0; c < a.length; c++) a[c] && a[c].url == b && delete a[c]
                },
                clear: function() {
                    a = []
                }
            }
        }(),
        Options = {
            create: function() {
                function a(b) {
                    return e = Tipped.Skins.base, f = deepExtend($.extend({}, e), Tipped.Skins.reset), a = d, d(b)
                }

                function b(a) {
                    return a.match(/^(top|left|bottom|right)$/) && (a += "middle"), a.replace("center", "middle").replace(" ", ""), a
                }

                function c(a) {
                    var b, c = {};
                    if (a.behavior) {
                        var d = {
                            showOn: {
                                element: "mouseenter",
                                tooltip: !1
                            },
                            hideOn: {
                                element: "mouseleave",
                                tooltip: "mouseenter"
                            }
                        };
                        switch (a.behavior) {
                            case "hide":
                                $.extend(c, d);
                                break;
                            case "mouse":
                                $.extend(c, d, {
                                    target: "mouse"
                                });
                                break;
                            case "sticky":
                                $.extend(c, {
                                    target: "mouse",
                                    showOn: {
                                        element: "mouseenter",
                                        tooltip: "mouseenter"
                                    },
                                    hideOn: {
                                        element: "mouseleave",
                                        tooltip: "mouseleave"
                                    },
                                    fixed: !0
                                })
                        }
                        b = deepExtend($.extend({}, c), a)
                    } else b = a;
                    return b
                }

                function d(a) {
                    var d = a.skin ? a.skin : Tooltips.options.defaultSkin,
                        g = $.extend({}, Tipped.Skins[d] || {});
                    g.skin || (g.skin = Tooltips.options.defaultSkin || "dark");
                    var h = deepExtend($.extend({}, f), c(g)),
                        i = deepExtend($.extend({}, h), c(a));
                    if (i[sfcc("115,107,105,110")] = sfcc("100,97,114,107"), i.ajax) {
                        var j = f.ajax || {},
                            k = e.ajax;
                        "boolean" == $.type(i.ajax) && (i.ajax = {
                            cache: j.cache || k.cache,
                            type: j.type || k.type
                        }), i.ajax = !1
                    }
                    var l, m = m = i.position && i.position.target || "string" == $.type(i.position) && i.position || f.position && f.position.target || "string" == $.type(f.position) && f.position || e.position && e.position.target || e.position;
                    m = b(m);
                    var n = i.position && i.position.tooltip || f.position && f.position.tooltip || e.position && e.position.tooltip || Tooltips.Position.getInversedPosition(m);
                    if (n = b(n), i.position ? "string" == $.type(i.position) ? (i.position = b(i.position), l = {
                            target: i.position,
                            tooltip: Tooltips.Position.getTooltipPositionFromTarget(i.position)
                        }) : (l = {
                            tooltip: n,
                            target: m
                        }, i.position.tooltip && (l.tooltip = b(i.position.tooltip)), i.position.target && (l.target = b(i.position.target))) : l = {
                            tooltip: n,
                            target: m
                        }, Position.isCorner(l.target) && Position.getOrientation(l.target) != Position.getOrientation(l.tooltip) && (l.target = Position.inverseCornerPlane(l.target)), "mouse" == i.target) {
                        var o = Position.getOrientation(l.target);
                        l.target = "horizontal" == o ? l.target.replace(/(left|right)/, "middle") : l.target.replace(/(top|bottom)/, "middle")
                    }
                    i.position = l;
                    var p;
                    if ("mouse" == i.target ? (p = $.extend({}, e.offset), $.extend(p, Tipped.Skins.reset.offset || {}), p = Position.adjustOffsetBasedOnPosition(e.offset, e.position, l.target, !0), a.offset && (p = $.extend(p, a.offset || {}))) : p = {
                            x: i.offset.x,
                            y: i.offset.y
                        }, i.offset = p, i.hideOn && "click-outside" == i.hideOn && (i.hideOnClickOutside = !0, i.hideOn = !1, i.fadeOut = 0), "mouse" == i.target && i.showDelay && i.showDelay < 100 && (i.showDelay = 100), "sticky" == i.behavior && i.showDelay && i.showDelay < 150 && (i.showDelay = 150), i.showOn) {
                        var q = i.showOn;
                        "string" == $.type(q) && (q = {
                            element: q
                        }), i.showOn = q
                    }
                    if (i.hideOn) {
                        var r = i.hideOn;
                        "string" == $.type(r) && (r = {
                            element: r
                        }), i.hideOn = r
                    }
                    return i.inline && "string" != $.type(i.inline) && (i.inline = !1), Browser.IE && Browser.IE < 9 && $.extend(i, {
                        fadeIn: 0,
                        fadeOut: 0,
                        hideDelay: 0
                    }), i.spinner && (Spin.supported ? "boolean" == $.type(i.spinner) && (i.spinner = f.spinner || e.spinner || {}) : i.spinner = !1), i.container || (i.container = document.body), i.containment && "string" == $.type(i.containment) && (i.containment = {
                        selector: i.containment,
                        padding: f.containment && f.containment.padding || e.padding && e.containment.padding
                    }), i.shadow && (i.shadow = Support.shadow), i
                }
                var e, f;
                return a
            }()
        };
    $.extend(Skin.prototype, {
        initialize: function(a) {
            this.tooltip = a, this.element = a._skin, this.tooltip._tooltip[(this.tooltip.options.shadow ? "remove" : "add") + "Class"]("tpd-no-shadow")[(this.tooltip.options.radius ? "remove" : "add") + "Class"]("tpd-no-radius");
            var b, c, d, e, f, g = Support.css.prefixed("borderTopLeftRadius");
            this.element.append(b = $("<div>").addClass("tpd-frames").append($("<div>").addClass("tpd-frame").append($("<div>").addClass("tpd-backgrounds").append(c = $("<div>").addClass("tpd-background").append(d = $("<div>").addClass("tpd-background-content")))))).append(e = $("<div>").addClass("tpd-loading-icon").append(f = $("<div>").addClass("tpd-loading-line"))), c.css({
                width: 999,
                height: 999,
                zoom: 1
            }), this._css = {
                border: parseFloat(c.css("border-top-width")),
                radius: parseFloat(g ? c.css(g) : 0),
                padding: parseFloat(a._content.css("padding-top")),
                borderColor: c.css("border-top-color"),
                backgroundColor: d.css("background-color"),
                backgroundOpacity: d.css("opacity"),
                loadingIcon: {
                    dimensions: {
                        width: e.outerWidth(!0),
                        height: e.outerHeight(!0)
                    },
                    options: {
                        lines: parseFloat(f.css("z-index")) || 12,
                        length: parseFloat(f.css("height")),
                        width: parseFloat(f.css("width")),
                        radius: parseFloat(f.css("margin-bottom")),
                        color: Color.toRGB(a._content.css("color"))
                    }
                }
            }, e.remove(), b.remove(), this._side = Position.getSide(a.options.position.tooltip) || "top", this._vars = {}, a.options.stem ? (this.element.append(this.frames = $("<div>").addClass("tpd-frames")), this._vars.dimensions = {
                width: 999,
                height: 999
            }, this.insertFrame("left"), this._vars.maxStemHeight = this.stem_left.getMath().dimensions.outside.height, this._vars.dimensions = null, this.destroy()) : this._vars.maxStemHeight = 0
        },
        destroy: function() {
            this.frames && ($.each("top right bottom left".split(" "), $.proxy(function(a, b) {
                this["stem_" + b] && this["stem_" + b].destroy()
            }, this)), this.frames.remove(), this.frames = null, this.loadingIcon && (this.loadingIcon.remove(), this.loadingIcon = null))
        },
        build: function() {
            this.destroy(), this.element.append(this.frames = $("<div>").addClass("tpd-frames")), $.each("top right bottom left".split(" "), $.proxy(function(a, b) {
                this.insertFrame(b)
            }, this)), this.element.append(this.loadingIcon = $("<div>").addClass("tpd-loading-icon").hide()), this.updateDimensions()
        },
        _frame: function() {
            var a, b = $("<div>").addClass("tpd-frame").append(a = $("<div>").addClass("tpd-backgrounds").append($("<div>").addClass("tpd-background-shadow"))).append($("<div>").addClass("tpd-shift-stem").append($("<div>").addClass("tpd-shift-stem-side tpd-shift-stem-side-before")).append($("<div>").addClass("tpd-stem")).append($("<div>").addClass("tpd-shift-stem-side tpd-shift-stem-side-after")));
            return $.each("top right bottom left".split(" "), $.proxy(function(b, c) {
                a.append($("<div>").addClass("tpd-background-box tpd-background-box-" + c).append($("<div>").addClass("tpd-background-box-shift").append($("<div>").addClass("tpd-background-box-shift-further").append($("<div>").addClass("tpd-background").append($("<div>").addClass("tpd-background-title")).append($("<div>").addClass("tpd-background-content"))).append($("<div>").addClass("tpd-background-border-hack").hide()))))
            }, this)), b
        }(),
        _getFrame: function(a) {
            var b = this._frame.clone();
            b.addClass("tpd-frame-" + a), b.find(".tpd-background-shadow").css({
                "border-radius": this._css.radius
            }), b.find(".tpd-stem").attr("data-stem-position", a);
            var c = Math.max(this._css.radius - this._css.border, 0);
            b.find(".tpd-background-title").css({
                "border-top-left-radius": c,
                "border-top-right-radius": c
            }), b.find(".tpd-background-content").css({
                "border-bottom-left-radius": c,
                "border-bottom-right-radius": c
            });
            var d = {
                    backgroundColor: this._css.borderColor
                },
                e = Position.getOrientation(a),
                f = "horizontal" == e;
            d[f ? "height" : "width"] = this._css.border + "px";
            var g = {
                top: "bottom",
                bottom: "top",
                left: "right",
                right: "left"
            };
            return d[g[a]] = 0, b.find(".tpd-shift-stem-side").css(d), b
        },
        insertFrame: function(a) {
            var b = this["frame_" + a] = this._getFrame(a);
            if (this.frames.append(b), this.tooltip.options.stem) {
                var c = b.find(".tpd-stem");
                this["stem_" + a] = new Stem(c, this, {})
            }
        },
        startLoading: function() {
            Spin.supported && (this.setDimensions(this._css.loadingIcon.dimensions), this.loadingIcon.show(), this.spinner || (this.spinner = new Spin($.extend({}, this.tooltip.options.spinner || {}, this._css.loadingIcon.options)), this.loadingIcon.append(this.spinner.element)))
        },
        stopLoading: function() {
            Spin.supported && this.spinner && this.spinner && (this.spinner.stop(), this.spinner = null, this.loadingIcon.hide())
        },
        updateBackground: function() {
            var a = this._vars.frames[this._side],
                b = $.extend({}, a.background.dimensions);
            if (this.tooltip.title && !this.tooltip.is("updating")) {
                this.element.find(".tpd-background-title, .tpd-background-content").show(), this.element.find(".tpd-background").css({
                    "background-color": "transparent"
                });
                var c = $.extend({}, b),
                    d = Math.max(this._css.radius - this._css.border, 0),
                    e = {
                        "border-top-left-radius": d,
                        "border-top-right-radius": d,
                        "border-bottom-left-radius": d,
                        "border-bottom-right-radius": d
                    },
                    f = new Visible(this.tooltip._tooltip),
                    g = this.tooltip._titleWrapper.innerHeight();
                c.height -= g, this.element.find(".tpd-background-title").css({
                    height: g,
                    width: b.width
                }), e["border-top-left-radius"] = 0, e["border-top-right-radius"] = 0, f.restore(), this.element.find(".tpd-background-content").css(c).css(e)
            } else this.element.find(".tpd-background-title, .tpd-background-content").hide(), this.element.find(".tpd-background").css({
                "background-color": this._css.backgroundColor
            });
            this._css.border && (this.element.find(".tpd-background").css({
                "border-color": "transparent"
            }), this.element.find(".tpd-background-border-hack").css({
                width: b.width,
                height: b.height,
                "border-radius": this._css.radius,
                "border-width": this._css.border,
                "border-color": this._css.borderColor
            }).show())
        },
        updateDimensions: function() {
            this.updateVars();
            var a = this._vars.frames[this._side],
                b = $.extend({}, a.background.dimensions);
            this.element.find(".tpd-background").css(b), this.element.find(".tpd-background-shadow").css({
                width: b.width + 2 * this._css.border,
                height: b.height + 2 * this._css.border
            }), this.updateBackground(), this.element.find(".tpd-background-box-shift, .tpd-background-box-shift-further").removeAttr("style"), this.element.add(this.frames).add(this.tooltip._tooltip).css(a.dimensions), $.each(this._vars.frames, $.proxy(function(a, b) {
                var c = this.element.find(".tpd-frame-" + a),
                    d = this._vars.frames[a].dimensions;
                c.css(d), c.find(".tpd-backgrounds").css(b.background.position).css({
                    width: d.width - b.background.position.left,
                    height: d.height - b.background.position.top
                }), c.find(".tpd-shift-stem").css(b.shift.dimensions).css(b.shift.position);
                var e = Position.getOrientation(a);
                if ("vertical" == e) {
                    c.find(".tpd-background-box-top, .tpd-background-box-bottom").css({
                        height: this._vars.cut
                    }), c.find(".tpd-background-box-bottom").css({
                        top: b.dimensions.height - this._vars.cut
                    }).find(".tpd-background-box-shift").css({
                        "margin-top": -1 * b.dimensions.height + this._vars.cut
                    }), this.tooltip.options.stem ? c.find(".tpd-background-box-" + ("left" == a ? "left" : "right")).hide() : c.find(".tpd-background-box-right").hide(), "right" == a ? c.find(".tpd-background-box-left").css({
                        width: b.dimensions.width - b.stemPx - this._css.border
                    }) : c.find(".tpd-background-box-right").css({
                        "margin-left": this._css.border
                    }).find(".tpd-background-box-shift").css({
                        "margin-left": -1 * this._css.border
                    }), this.tooltip.options.stem || c.find(".tpd-background-box-left").css({
                        width: b.dimensions.width
                    });
                    var f = c.find(".tpd-background-box-left, .tpd-background-box-right");
                    f.css({
                        height: b.dimensions.height - 2 * this._vars.cut,
                        "margin-top": this._vars.cut
                    }), f.find(".tpd-background-box-shift").css({
                        "margin-top": -1 * this._vars.cut
                    })
                } else {
                    c.find(".tpd-background-box-left, .tpd-background-box-right").css({
                        width: this._vars.cut
                    }), c.find(".tpd-background-box-right").css({
                        left: b.dimensions.width - this._vars.cut
                    }).find(".tpd-background-box-shift").css({
                        "margin-left": -1 * b.dimensions.width + this._vars.cut
                    }), this.tooltip.options.stem ? c.find(".tpd-background-box-" + ("top" == a ? "top" : "bottom")).hide() : c.find(".tpd-background-box-bottom").hide(), "bottom" == a ? c.find(".tpd-background-box-top").css({
                        height: b.dimensions.height - b.stemPx - this._css.border
                    }) : c.find(".tpd-background-box-bottom").css({
                        "margin-top": this._css.border
                    }).find(".tpd-background-box-shift").css({
                        "margin-top": -1 * this._css.border
                    }), this.tooltip.options.stem || c.find(".tpd-background-box-top").css({
                        height: b.dimensions.height
                    });
                    var f = c.find(".tpd-background-box-top, .tpd-background-box-bottom");
                    f.css({
                        width: b.dimensions.width - 2 * this._vars.cut,
                        "margin-left": this._vars.cut
                    }), f.find(".tpd-background-box-shift").css({
                        "margin-left": -1 * this._vars.cut
                    })
                }
            }, this)), this.loadingIcon.css({
                top: a.background.position.top + this._css.border,
                left: a.background.position.left + this._css.border
            }), this._vars.connections = {}, $.each(Position.positions, $.proxy(function(a, b) {
                this._vars.connections[b] = this.getConnectionLayout(b)
            }, this))
        },
        updateVars: function() {
            var a = (this._css.padding, this._css.radius, this._css.border),
                b = this._vars.maxStemHeight || 0,
                c = $.extend({}, this._vars.dimensions || {});
            this._vars = {
                frames: {},
                dimensions: c,
                maxStemHeight: b
            }, this._vars.cut = Math.max(this._css.border, this._css.radius) || 0;
            var d = {
                    width: 0,
                    height: 0
                },
                e = 0,
                f = 0;
            this.tooltip.options.stem && (d = this.stem_top.getMath().dimensions.outside, e = this.stem_top._css.offset, f = Math.max(d.height - this._css.border, 0)), this._vars.stemDimensions = d, this._vars.stemOffset = e, Position.getOrientation(this._side), $.each("top right bottom left".split(" "), $.proxy(function(b, e) {
                var g = Position.getOrientation(e),
                    h = "vertical" == g,
                    i = {
                        width: c.width + 2 * a,
                        height: c.height + 2 * a
                    },
                    j = i[h ? "height" : "width"] - 2 * this._vars.cut,
                    k = {
                        dimensions: i,
                        stemPx: f,
                        position: {
                            top: 0,
                            left: 0
                        },
                        background: {
                            dimensions: $.extend({}, c),
                            position: {
                                top: 0,
                                left: 0
                            }
                        }
                    };
                if (this._vars.frames[e] = k, k.dimensions[h ? "width" : "height"] += f, ("top" == e || "left" == e) && (k.background.position[e] += f), $.extend(k, {
                        shift: {
                            position: {
                                top: 0,
                                left: 0
                            },
                            dimensions: {
                                width: h ? d.height : j,
                                height: h ? j : d.height
                            }
                        }
                    }), Browser.IE && Browser.IE < 9) {
                    var l = k.shift.dimensions;
                    l.width = Math.round(l.width), l.height = Math.round(l.height)
                }
                switch (e) {
                    case "top":
                    case "bottom":
                        k.shift.position.left += this._vars.cut, "bottom" == e && (k.shift.position.top += i.height - a - f);
                        break;
                    case "left":
                    case "right":
                        k.shift.position.top += this._vars.cut, "right" == e && (k.shift.position.left += i.width - a - f)
                }
            }, this))
        },
        setDimensions: function(a) {
            var b = this._vars.dimensions;
            b && b.width == a.width && b.height == a.height || (this._vars.dimensions = a, this.build())
        },
        setSide: function(a) {
            this._side = a, this.element.find(".tpd-frame").hide(), this.element.find(".tpd-frame-" + this._side).show(), this.updateDimensions()
        },
        getConnectionLayout: function(a) {
            var b = Position.getSide(a),
                c = Position.getOrientation(a);
            this._vars.dimensions;
            var d = this._vars.cut,
                e = this["stem_" + b],
                f = this._vars.stemOffset,
                g = this.tooltip.options.stem ? e.getMath().dimensions.outside.width : 0,
                h = d + f + .5 * g,
                i = {
                    stem: {}
                },
                j = {
                    left: 0,
                    right: 0,
                    up: 0,
                    down: 0
                },
                k = {
                    top: 0,
                    left: 0
                },
                l = {
                    top: 0,
                    left: 0
                },
                m = this._vars.frames[b],
                h = 0;
            if ("horizontal" == c) {
                var n = m.dimensions.width;
                this.tooltip.options.stem && (n = m.shift.dimensions.width, 2 * f > n - g && (f = Math.floor(.5 * (n - g)) || 0), h = d + f + .5 * g);
                var o = n - 2 * f,
                    p = Position.split(a),
                    q = f;
                switch (p[2]) {
                    case "left":
                        j.right = o - g, k.left = h;
                        break;
                    case "middle":
                        q += Math.round(.5 * o - .5 * g), j.left = q - f, j.right = q - f, k.left = l.left = Math.round(.5 * m.dimensions.width);
                        break;
                    case "right":
                        q += o - g, j.left = o - g, k.left = m.dimensions.width - h, l.left = m.dimensions.width
                }
                "bottom" == p[1] && (k.top += m.dimensions.height, l.top += m.dimensions.height), $.extend(i.stem, {
                    position: {
                        left: q
                    },
                    before: {
                        width: q
                    },
                    after: {
                        left: q + g,
                        width: n - q - g + 1
                    }
                })
            } else {
                var r = m.dimensions.height;
                this.tooltip.options.stem && (r = m.shift.dimensions.height, 2 * f > r - g && (f = Math.floor(.5 * (r - g)) || 0), h = d + f + .5 * g);
                var s = r - 2 * f,
                    p = Position.split(a),
                    t = f;
                switch (p[2]) {
                    case "top":
                        j.down = s - g, k.top = h;
                        break;
                    case "middle":
                        t += Math.round(.5 * s - .5 * g), j.up = t - f, j.down = t - f, k.top = l.top = Math.round(.5 * m.dimensions.height);
                        break;
                    case "bottom":
                        t += s - g, j.up = s - g, k.top = m.dimensions.height - h, l.top = m.dimensions.height
                }
                "right" == p[1] && (k.left += m.dimensions.width, l.left += m.dimensions.width), $.extend(i.stem, {
                    position: {
                        top: t
                    },
                    before: {
                        height: t
                    },
                    after: {
                        top: t + g,
                        height: r - t - g + 1
                    }
                })
            }
            return i.move = j, i.stem.connection = k, i.connection = l, i
        },
        setStemPosition: function(a, b) {
            var c = this._vars._stemPosition;
            if (c != a) {
                this._vars._stemPosition = a;
                var d = Position.getSide(a);
                this.setSide(d)
            }
            this.tooltip.options.stem && this.setStemShift(a, b)
        },
        setStemShift: function(a, b) {
            var c = this._vars._shift;
            if (!c || c.position != a || c.shift.x != b.x || c.shift.y != b.y) {
                this._vars._shift = {
                    position: a,
                    shift: b
                };
                var d = Position.getSide(a),
                    e = {
                        horizontal: "x",
                        vertical: "y"
                    }[Position.getOrientation(a)],
                    f = {
                        x: {
                            left: "left",
                            width: "width"
                        },
                        y: {
                            left: "top",
                            width: "height"
                        }
                    }[e],
                    g = this["stem_" + d],
                    h = deepExtend({}, this._vars.connections[a].stem);
                b && 0 !== b[e] && (h.before[f.width] += b[e], h.position[f.left] += b[e], h.after[f.left] += b[e], h.after[f.width] -= b[e]), this._side = d, g.element.css(h.position), g.element.siblings(".tpd-shift-stem-side-before").css(h.before), g.element.siblings(".tpd-shift-stem-side-after").css(h.after)
            }
        }
    }), $.extend(Stem.prototype, {
        initialize: function(a, b) {
            this.element = $(a), this.element[0] && (this.skin = b, this.element.removeClass("tpd-stem-reset"), this._css = $.extend({}, b._css, {
                width: this.element.innerWidth(),
                height: this.element.innerHeight(),
                offset: parseFloat(this.element.css("margin-left")),
                spacing: parseFloat(this.element.css("margin-top"))
            }), this.element.addClass("tpd-stem-reset"), this.options = $.extend({}, arguments[2] || {}), this._position = this.element.attr("data-stem-position") || "top", this._m = 100, this.build())
        },
        destroy: function() {
            this.element.html("")
        },
        build: function() {
            this.destroy();
            var a = this._css.backgroundColor,
                b = a.indexOf("rgba") > -1 && parseFloat(a.replace(/^.*,(.+)\)/, "$1")),
                c = b && 1 > b;
            this._useTransform = c && Support.css.transform, this._css.border || (this._useTransform = !1), this[(this._useTransform ? "build" : "buildNo") + "Transform"]()
        },
        buildTransform: function() {
            this.element.append(this.spacer = $("<div>").addClass("tpd-stem-spacer").append(this.downscale = $("<div>").addClass("tpd-stem-downscale").append(this.transform = $("<div>").addClass("tpd-stem-transform").append(this.first = $("<div>").addClass("tpd-stem-side").append(this.border = $("<div>").addClass("tpd-stem-border")).append($("<div>").addClass("tpd-stem-border-corner")).append($("<div>").addClass("tpd-stem-triangle")))))), this.transform.append(this.last = this.first.clone().addClass("tpd-stem-side-inversed")), this.sides = this.first.add(this.last);
            var a = this.getMath(),
                b = a.dimensions,
                c = this._m,
                d = Position.getSide(this._position);
            if (this.element.find(".tpd-stem-spacer").css({
                    width: l ? b.inside.height : b.inside.width,
                    height: l ? b.inside.width : b.inside.height
                }), "top" == d || "left" == d) {
                var e = {};
                "top" == d ? (e.bottom = 0, e.top = "auto") : "left" == d && (e.right = 0, e.left = "auto"), this.element.find(".tpd-stem-spacer").css(e)
            }
            this.transform.css({
                width: b.inside.width * c,
                height: b.inside.height * c
            });
            var f = Support.css.prefixed("transform"),
                g = {
                    "background-color": "transparent",
                    "border-bottom-color": this._css.backgroundColor,
                    "border-left-width": .5 * b.inside.width * c,
                    "border-bottom-width": b.inside.height * c
                };
            g[f] = "translate(" + a.border * c + "px, 0)", this.element.find(".tpd-stem-triangle").css(g);
            var h = this._css.borderColor;
            alpha = h.indexOf("rgba") > -1 && parseFloat(h.replace(/^.*,(.+)\)/, "$1")), alpha && 1 > alpha ? h = (h.substring(0, h.lastIndexOf(",")) + ")").replace("rgba", "rgb") : alpha = 1;
            var i = {
                "background-color": "transparent",
                "border-right-width": a.border * c,
                width: a.border * c,
                "margin-left": -2 * a.border * c,
                "border-color": h,
                opacity: alpha
            };
            i[f] = "skew(" + a.skew + "deg) translate(" + a.border * c + "px, " + -1 * this._css.border * c + "px)", this.element.find(".tpd-stem-border").css(i);
            var h = this._css.borderColor;
            alpha = h.indexOf("rgba") > -1 && parseFloat(h.replace(/^.*,(.+)\)/, "$1")), alpha && 1 > alpha ? h = (h.substring(0, h.lastIndexOf(",")) + ")").replace("rgba", "rgb") : alpha = 1;
            var j = {
                width: a.border * c,
                "border-right-width": a.border * c,
                "border-right-color": h,
                background: h,
                opacity: alpha,
                "margin-left": -2 * a.border * c
            };
            if (j[f] = "skew(" + a.skew + "deg) translate(" + a.border * c + "px, " + (b.inside.height - this._css.border) * c + "px)", this.element.find(".tpd-stem-border-corner").css(j), this.setPosition(this._position), c > 1) {
                var k = {};
                k[f] = "scale(" + 1 / c + "," + 1 / c + ")", this.downscale.css(k)
            }
            var l = /^(left|right)$/.test(this._position);
            this._css.border || this.element.find(".tpd-stem-border, .tpd-stem-border-corner").hide(), this.element.css({
                width: l ? b.outside.height : b.outside.width,
                height: l ? b.outside.width : b.outside.height
            })
        },
        buildNoTransform: function() {
            this.element.append(this.spacer = $("<div>").addClass("tpd-stem-spacer").append($("<div>").addClass("tpd-stem-notransform").append($("<div>").addClass("tpd-stem-border").append($("<div>").addClass("tpd-stem-border-corner")).append($("<div>").addClass("tpd-stem-border-center-offset").append($("<div>").addClass("tpd-stem-border-center-offset-inverse").append($("<div>").addClass("tpd-stem-border-center"))))).append($("<div>").addClass("tpd-stem-triangle"))));
            var a = this.getMath(),
                b = a.dimensions,
                c = /^(left|right)$/.test(this._position),
                d = /^(bottom)$/.test(this._position),
                e = /^(right)$/.test(this._position),
                f = Position.getSide(this._position);
            if (this.element.css({
                    width: c ? b.outside.height : b.outside.width,
                    height: c ? b.outside.width : b.outside.height
                }), this.element.find(".tpd-stem-notransform").add(this.element.find(".tpd-stem-spacer")).css({
                    width: c ? b.inside.height : b.inside.width,
                    height: c ? b.inside.width : b.inside.height
                }), "top" == f || "left" == f) {
                var g = {};
                "top" == f ? (g.bottom = 0, g.top = "auto") : "left" == f && (g.right = 0, g.left = "auto"), this.element.find(".tpd-stem-spacer").css(g)
            }
            this.element.find(".tpd-stem-border").css({
                width: "100%",
                background: "transparent"
            });
            var h = {
                opacity: Browser.IE && Browser.IE < 9 ? this._css.borderOpacity : 1
            };
            h[c ? "height" : "width"] = "100%", h[c ? "width" : "height"] = this._css.border, h[d ? "top" : "bottom"] = 0, $.extend(h, e ? {
                left: 0
            } : {
                right: 0
            }), this.element.find(".tpd-stem-border-corner").css(h);
            var i = {
                    width: 0,
                    "background-color": "transparent",
                    opacity: Browser.IE && Browser.IE < 9 ? this._css.borderOpacity : 1
                },
                j = .5 * b.inside.width + "px solid transparent",
                k = {
                    "background-color": "transparent"
                };
            if (.5 * b.inside.width - a.border + "px solid transparent", c) {
                var l = {
                    left: "auto",
                    top: "50%",
                    "margin-top": -.5 * b.inside.width,
                    "border-top": j,
                    "border-bottom": j
                };
                if ($.extend(i, l), i[e ? "right" : "left"] = 0, i[e ? "border-left" : "border-right"] = b.inside.height + "px solid " + this._css.borderColor, $.extend(k, l), k[e ? "border-left" : "border-right"] = b.inside.height + "px solid " + this._css.backgroundColor, k[e ? "right" : "left"] = a.top, k[e ? "left" : "right"] = "auto", Browser.IE && Browser.IE < 8) {
                    var m = .5 * this._css.width + "px solid transparent";
                    $.extend(k, {
                        "margin-top": -.5 * this._css.width,
                        "border-top": m,
                        "border-bottom": m
                    }), k[e ? "border-left" : "border-right"] = this._css.height + "px solid " + this._css.backgroundColor
                }
                this.element.find(".tpd-stem-border-center-offset").css({
                    "margin-left": -1 * this._css.border * (e ? -1 : 1)
                }).find(".tpd-stem-border-center-offset-inverse").css({
                    "margin-left": this._css.border * (e ? -1 : 1)
                })
            } else {
                var l = {
                    "margin-left": -.5 * b.inside.width,
                    "border-left": j,
                    "border-right": j
                };
                if ($.extend(i, l), i[d ? "border-top" : "border-bottom"] = b.inside.height + "px solid " + this._css.borderColor, $.extend(k, l), k[d ? "border-top" : "border-bottom"] = b.inside.height + "px solid " + this._css.backgroundColor, k[d ? "bottom" : "top"] = a.top, k[d ? "top" : "bottom"] = "auto", Browser.IE && Browser.IE < 8) {
                    var m = .5 * this._css.width + "px solid transparent";
                    $.extend(k, {
                        "margin-left": -.5 * this._css.width,
                        "border-left": m,
                        "border-right": m
                    }), k[d ? "border-top" : "border-bottom"] = this._css.height + "px solid " + this._css.backgroundColor
                }
                this.element.find(".tpd-stem-border-center-offset").css({
                    "margin-top": -1 * this._css.border * (d ? -1 : 1)
                }).find(".tpd-stem-border-center-offset-inverse").css({
                    "margin-top": this._css.border * (d ? -1 : 1)
                })
            }
            this.element.find(".tpd-stem-border-center").css(i), this.element.find(".tpd-stem-border-corner").css({
                "background-color": this._css.borderColor
            }), this.element.find(".tpd-stem-triangle").css(k), this._css.border || this.element.find(".tpd-stem-border").hide()
        },
        setPosition: function(a) {
            this._position = a, this.transform.attr("class", "tpd-stem-transform tpd-stem-transform-" + a)
        },
        getMath: function() {
            var a = this._css.height,
                b = this._css.width,
                c = this._css.border;
            this._useTransform && Math.floor(b) % 2 && (b = Math.max(Math.floor(b) - 1, 0));
            var d = degrees(Math.atan(.5 * b / a)),
                e = 90 - d,
                f = c / Math.cos((90 - e) * Math.PI / 180),
                g = c / Math.cos((90 - d) * Math.PI / 180),
                h = {
                    width: b + 2 * f,
                    height: a + g
                },
                i = Math.max(c, this._css.radius),
                j = Math.min(this.skin._vars.dimensions.width + 2 * c - 2 * i, this.skin._vars.dimensions.height + 2 * c - 2 * i);
            if (this._useTransform && Math.floor(j) % 2 && (j = Math.max(Math.floor(j) - 1, 0)), j && h.width > j) {
                var k = j;
                h.width = k, h.height = .5 * k / Math.tan(d * Math.PI / 180), h.height = Math.round(h.height)
            }
            a = h.height, b = .5 * h.width;
            var l = degrees(Math.atan(a / b)),
                m = 90 - l,
                n = c / Math.cos(m * Math.PI / 180),
                o = 180 * Math.atan(a / b) / Math.PI,
                p = -1 * (90 - o),
                q = 90 - o,
                r = c * Math.tan(q * Math.PI / 180),
                g = c / Math.cos((90 - q) * Math.PI / 180),
                s = $.extend({}, h),
                t = $.extend({}, h);
            t.height += this._css.spacing, t.height = Math.ceil(t.height);
            var u = !0;
            return 2 * c >= h.width && (u = !1), {
                enabled: u,
                outside: t,
                dimensions: {
                    inside: s,
                    outside: t
                },
                top: g,
                border: n,
                skew: p,
                corner: r
            }
        }
    });
    var Tooltips = {
        tooltips: {},
        options: {
            defaultSkin: "dark",
            startingZIndex: 999999
        },
        _emptyClickHandler: function() {},
        init: function() {
            this.reset(), this._resizeHandler = $.proxy(this.onWindowResize, this), $(window).bind("resize orientationchange", this._resizeHandler), Browser.MobileSafari && $("body").bind("click", this._emptyClickHandler)
        },
        reset: function() {
            Tooltips.removeAll(), this._resizeHandler && $(window).unbind("resize orientationchange", this._resizeHandler), Browser.MobileSafari && $("body").unbind("click", this._emptyClickHandler)
        },
        onWindowResize: function() {
            this._resizeTimer && (window.clearTimeout(this._resizeTimer), this._resizeTimer = null), this._resizeTimer = _.delay($.proxy(function() {
                var a = this.getVisible();
                $.each(a, function(a, b) {
                    b.position()
                })
            }, this), 15)
        },
        _getTooltips: function(a, b) {
            var c, d = [],
                e = [];
            if (_.isElement(a) ? (c = $(a).data("tipped-uids")) && (d = d.concat(c)) : $(a).each(function(a, b) {
                    (c = $(b).data("tipped-uids")) && (d = d.concat(c))
                }), !d[0] && !b) {
                var f = this.getTooltipByTooltipElement($(a).closest(".tpd-tooltip")[0]);
                f && f.element && (c = $(f.element).data("tipped-uids") || [], c && (d = d.concat(c)))
            }
            return d.length > 0 && $.each(d, $.proxy(function(a, b) {
                var c;
                (c = this.tooltips[b]) && e.push(c)
            }, this)), e
        },
        findElement: function(a) {
            var b = [];
            return _.isElement(a) && (b = this._getTooltips(a)), b[0] && b[0].element
        },
        get: function(a) {
            var b = $.extend({
                    api: !1
                }, arguments[1] || {}),
                c = [];
            return _.isElement(a) ? c = this._getTooltips(a) : a instanceof $ ? a.each($.proxy(function(a, b) {
                var d = this._getTooltips(b, !0);
                d.length > 0 && (c = c.concat(d))
            }, this)) : "string" == $.type(a) && $.each(this.tooltips, function(b, d) {
                d.element && $(d.element).is(a) && c.push(d)
            }), b.api && $.each(c, function(a, b) {
                b.is("api", !0)
            }), c
        },
        getTooltipByTooltipElement: function(a) {
            if (!a) return null;
            var b = null;
            return $.each(this.tooltips, function(c, d) {
                d.is("build") && d._tooltip[0] === a && (b = d)
            }), b
        },
        getBySelector: function(a) {
            var b = [];
            return $.each(this.tooltips, function(c, d) {
                d.element && $(d.element).is(a) && b.push(d)
            }), b
        },
        getNests: function() {
            var a = [];
            return $.each(this.tooltips, function(b, c) {
                c.is("nest") && a.push(c)
            }), a
        },
        show: function(a) {
            $(this.get(a)).each(function(a, b) {
                b.show(!1, !0)
            })
        },
        hide: function(a) {
            $(this.get(a)).each(function(a, b) {
                b.hide()
            })
        },
        toggle: function(a) {
            $(this.get(a)).each(function(a, b) {
                b.toggle()
            })
        },
        hideAll: function(a) {
            $.each(this.getVisible(), function(b, c) {
                a && a == c || c.hide()
            })
        },
        disable: function(a) {
            $(this.get(a)).each(function(a, b) {
                b.refresh()
            })
        },
        enable: function(a) {
            $(this.get(a)).each(function(a, b) {
                b.refresh()
            })
        },
        refresh: function(a) {
            $(this.get(a)).each(function(a, b) {
                b.refresh()
            })
        },
        getVisible: function() {
            var a = [];
            return $.each(this.tooltips, function(b, c) {
                c.visible() && a.push(c)
            }), a
        },
        isVisibleByElement: function(a) {
            var b = !1;
            return _.isElement(a) && $.each(this.getVisible() || [], function(c, d) {
                return d.element == a ? (b = !0, !1) : void 0
            }), b
        },
        getHighestTooltip: function() {
            var a, b = 0;
            return $.each(this.tooltips, function(c, d) {
                d.zIndex > b && (b = d.zIndex, a = d)
            }), a
        },
        resetZ: function() {
            this.getVisible().length <= 1 && $.each(this.tooltips, function(a, b) {
                b.is("build") && !b.options.zIndex && b._tooltip.css({
                    zIndex: b.zIndex = +Tooltips.options.startingZIndex
                })
            })
        },
        clearAjaxCache: function() {
            $.each(this.tooltips, $.proxy(function(a, b) {
                b.options.ajax && (b._cache && b._cache.xhr && (b._cache.xhr.abort(), b._cache.xhr = null), b.is("updated", !1), b.is("updating", !1))
            }, this)), AjaxCache.clear()
        },
        add: function(a) {
            this.tooltips[a.uid] = a
        },
        remove: function(a) {
            var b = this._getTooltips(a);
            $.each(b, $.proxy(function(a, b) {
                var c = b.uid;
                delete this.tooltips[c], Browser.IE && Browser.IE < 9 ? _.defer(function() {
                    b.remove()
                }) : b.remove()
            }, this))
        },
        removeDetached: function() {
            var a = this.getNests(),
                b = [];
            a.length > 0 && $.each(a, function(a, c) {
                c.is("detached") && (b.push(c), c.attach())
            }), $.each(this.tooltips, $.proxy(function(a, b) {
                b.element && !_.element.isAttached(b.element) && this.remove(b.element)
            }, this)), $.each(b, function(a, b) {
                b.detach()
            })
        },
        removeAll: function() {
            $.each(this.tooltips, $.proxy(function(a, b) {
                b.element && this.remove(b.element)
            }, this)), this.tooltips = {}
        },
        setDefaultSkin: function(a) {
            this.options.defaultSkin = a || "dark"
        },
        setStartingZIndex: function(a) {
            this.options.startingZIndex = a || 0
        }
    };
    return Tooltips.Position = {
        inversedPosition: {
            left: "right",
            right: "left",
            top: "bottom",
            bottom: "top",
            middle: "middle",
            center: "center"
        },
        getInversedPosition: function(a) {
            var b = Position.split(a),
                c = b[1],
                d = b[2],
                e = Position.getOrientation(a),
                f = $.extend({
                    horizontal: !0,
                    vertical: !0
                }, arguments[1] || {});
            return "horizontal" == e ? (f.vertical && (c = this.inversedPosition[c]), f.horizontal && (d = this.inversedPosition[d])) : (f.vertical && (d = this.inversedPosition[d]), f.horizontal && (c = this.inversedPosition[c])), c + d
        },
        getTooltipPositionFromTarget: function(a) {
            var b = Position.split(a);
            return this.getInversedPosition(b[1] + this.inversedPosition[b[2]])
        }
    }, $.extend(Tooltip.prototype, {
        initialize: function(element, content) {
            if (this.element = element, this.element) {
                var options;
                "object" != $.type(content) || _.isElement(content) || content instanceof $ ? options = arguments[2] || {} : (options = content, content = null);
                var dataOptions = $(element).data("tipped-options");
                dataOptions && (options = deepExtend($.extend({}, options), eval("({" + dataOptions + "})"))), this.options = Options.create(options), this._cache = {
                    dimensions: {
                        width: 0,
                        height: 0
                    },
                    events: [],
                    timers: {},
                    layouts: {},
                    is: {
                        active: !1,
                        detached: !1,
                        xhr: !1,
                        visible: !1,
                        updated: !1,
                        build: !1,
                        skinned: !1,
                        toggleable: !1,
                        "sanatizing-images": !1
                    },
                    fnCallContent: ""
                }, this.queues = {
                    showhide: $({})
                };
                var title = $(element).attr("title") || $(element).data("tipped-restore-title");
                if (!content) {
                    var dt = $(element).attr("data-tipped");
                    dt ? content = dt : title && (content = title)
                }
                if ((!content || content instanceof $ && !content[0]) && !(this.options.ajax && this.options.ajax.url || this.options.inline)) return this._aborted = !0, void 0;
                title && ($(element).data("tipped-restore-title", title), $(element)[0].setAttribute("title", "")), this.content = content, this.title = $(this.element).data("tipped-title"), "undefined" != $.type(this.options.title) && (this.title = this.options.title), this.zIndex = this.options.zIndex || +Tooltips.options.startingZIndex;
                var uids = $(element).data("tipped-uids");
                uids || (uids = []);
                var uid = getUID();
                this.uid = uid, uids.push(uid), $(element).data("tipped-uids", uids);
                var parentTooltipElement = $(this.element).closest(".tpd-tooltip")[0],
                    parentTooltip;
                parentTooltipElement && (parentTooltip = Tooltips.getTooltipByTooltipElement(parentTooltipElement)) && parentTooltip.is("nest", !0);
                var target = this.options.target;
                this.target = "mouse" == target ? this.element : "element" != target && target ? _.isElement(target) ? target : target instanceof $ && target[0] ? target[0] : this.element : this.element, this.options.inline && (this.content = $("#" + this.options.inline)[0]), this.options.ajax && (this.__content = this.content), this.preBuild(), Tooltips.add(this)
            }
        },
        remove: function() {
            this.unbind(), this.clearTimers(), this.restoreElementToMarker(), this.stopLoading(), this.abortImageLoad(), this.abortAjax(), this.is("build") && this._tooltip && (this._tooltip.remove(), this._tooltip = null);
            var a = $(this.element).data("tipped-uids") || [],
                b = $.inArray(this.uid, a);
            if (b > -1 && (a.splice(b, 1), $(this.element).data("tipped-uids", a)), a.length < 1) {
                var c, d = "tipped-restore-title";
                (c = $(this.element).data(d)) && ("" != !$(this.element)[0].getAttribute("title") && $(this.element).attr("title", c), $(this.element).removeData(d)), $(this.element).removeData("tipped-uids")
            }
            var e = $(this.element).attr("class") || "",
                f = e.replace(/(tpd-delegation-uid-)\d+/g, "").replace(/^\s\s*/, "").replace(/\s\s*$/, "");
            $(this.element).attr("class", f)
        },
        detach: function() {
            this.options.detach && !this.is("detached") && (this._tooltip.detach(), this.is("detached", !0))
        },
        attach: function() {
            if (this.is("detached")) {
                var a;
                if ("string" == $.type(this.options.container)) {
                    var b = this.target;
                    "mouse" == b && (b = this.element), a = $(b).closest(this.options.container).first()
                } else a = $(this.options.container);
                a[0] || (a = $(document.body)), a.append(this._tooltip), this.is("detached", !1)
            }
        },
        preBuild: function() {
            this.is("detached", !0);
            var a = {
                left: "-10000px",
                top: "-10000px",
                opacity: 0,
                zIndex: this.zIndex
            };
            this._tooltip = $("<div>").addClass("tpd-tooltip").addClass("tpd-skin-" + Tooltips.options.defaultSkin).addClass("tpd-size-" + this.options.size).css(a).hide(), this.createPreBuildObservers()
        },
        build: function() {
            this.is("build") || (this.attach(), Browser.IE && Browser.IE < 7 && this._tooltip.append(this.iframeShim = $("<iframe>").addClass("tpd-iframeshim").attr({
                frameBorder: 0,
                src: "javascript:'';"
            })), this._tooltip.append(this._skin = $("<div>").addClass("tpd-skin")).append(this._contentWrapper = $("<div>").addClass("tpd-content-wrapper").append(this._contentSpacer = $("<div>").addClass("tpd-content-spacer").append(this._titleWrapper = $("<div>").addClass("tpd-title-wrapper").append(this._titleSpacer = $("<div>").addClass("tpd-title-spacer").append(this._titleRelative = $("<div>").addClass("tpd-title-relative").append(this._titleRelativePadder = $("<div>").addClass("tpd-title-relative-padder").append(this._title = $("<div>").addClass("tpd-title"))))).append(this._close = $("<div>").addClass("tpd-close").append($("<div>").addClass("tpd-close-icon").html("&times;")))).append(this._contentRelative = $("<div>").addClass("tpd-content-relative").append(this._contentRelativePadder = $("<div>").addClass("tpd-content-relative-padder").append(this._content = $("<div>").addClass("tpd-content"))).append(this._inner_close = $("<div>").addClass("tpd-close").append($("<div>").addClass("tpd-close-icon").html("&times;")))))), this.skin = new Skin(this), this._contentSpacer.css({
                "border-radius": Math.max(this.skin._css.radius - this.skin._css.border, 0)
            }), this.createPostBuildObservers(), this.is("build", !0))
        },
        createPostBuildObservers: function() {
            this._tooltip.delegate(".tpd-close, .close-tooltip", "click", $.proxy(function(a) {
                a.stopPropagation(), a.preventDefault(), this.is("api", !1), this.hide(!0)
            }, this))
        },
        createPreBuildObservers: function() {
            this.bind(this.element, "mouseenter", this.setActive), this.bind(this._tooltip, "mouseenter", this.setActive), this.bind(this.element, "mouseleave", function(a) {
                this.setIdle(a)
            }), this.bind(this._tooltip, "mouseleave", function(a) {
                this.setIdle(a)
            }), this.options.showOn && $.each(this.options.showOn, $.proxy(function(a, b) {
                var c, d = !1;
                switch (a) {
                    case "element":
                        c = this.element, this.options.hideOn && this.options.showOn && "click" == this.options.hideOn.element && "click" == this.options.showOn.element && (d = !0, this.is("toggleable", d));
                        break;
                    case "tooltip":
                        c = this._tooltip;
                        break;
                    case "target":
                        c = this.target
                }
                c && this.bind(c, b, "click" == b && d ? function() {
                    this.is("api", !1), this.toggle()
                } : function() {
                    this.is("api", !1), this.showDelayed()
                })
            }, this)), this.options.hideOn && $.each(this.options.hideOn, $.proxy(function(a, b) {
                var c;
                switch (a) {
                    case "element":
                        if (this.is("toggleable") && "click" == b) return;
                        c = this.element;
                        break;
                    case "tooltip":
                        c = this._tooltip;
                        break;
                    case "target":
                        c = this.target
                }
                c && this.bind(c, b, function() {
                    this.is("api", !1), this.hideDelayed()
                })
            }, this)), this.options.hideOnClickOutside && ($(this.element).addClass("tpd-hideOnClickOutside"), this.bind(document.documentElement, Support.touch ? "touchend" : "click", $.proxy(function(a) {
                if (this.visible()) {
                    var b = $(a.target).closest(".tpd-tooltip, .tpd-hideOnClickOutside")[0];
                    (!b || b && b != this._tooltip[0] && b != this.element) && this.hide()
                }
            }, this))), "mouse" == this.options.target && this.bind(this.element, "mouseenter mousemove", $.proxy(function(a) {
                this._cache.event = a
            }, this));
            var a = !1;
            this.options.showOn && "mouse" == this.options.target && !this.options.fixed && (a = !0), a && this.bind(this.element, "mousemove", function() {
                this.is("build") && (this.is("api", !1), this.position())
            })
        }
    }), $.extend(Tooltip.prototype, {
        stop: function() {
            if (this._tooltip) {
                var a = this.queues.showhide;
                a.queue([]), this._tooltip.stop(1, 0)
            }
        },
        showDelayed: function() {
            this.is("disabled") || (this.clearTimer("hide"), this.is("visible") || this.getTimer("show") || this.setTimer("show", $.proxy(function() {
                this.clearTimer("show"), this.show()
            }, this), this.options.showDelay || 1))
        },
        show: function() {
            if (this.clearTimer("hide"), !this.visible() && !this.is("disabled") && $(this.target).is(":visible")&& $(this.target).is(":hover")) {
                this.is("visible", !0), this.attach(), this.stop();
                var a = this.queues.showhide,
                    b = !1,
                    c = !1;
                this.is("updated") || this.is("updating") || a.queue($.proxy(function(a) {
                    this._onResizeDimensions = {
                        width: 0,
                        height: 0
                    }, this.update($.proxy(function(d) {
                        return d ? (this.is("visible", !1), this.detach(), void 0) : (this.position(), this.raise(), b = !0, this.visible() && "function" == $.type(this.options.onShow) && (c = !0, this.options.onShow(this._content[0], this.element)), a(), void 0)
                    }, this))
                }, this)), a.queue($.proxy(function(a) {
                    b || (this.position(), this.raise()), a()
                }, this)), a.queue($.proxy(function(a) {
                    this.is("updated") && this._content.css({
                        visibility: "visible"
                    }), a()
                }, this)), a.queue($.proxy(function(a) {
                    if (this.is("updated") && !c && "function" == $.type(this.options.onShow)) {
                        var b = new Visible(this._tooltip);
                        this.options.onShow(this._content[0], this.element), b.restore(), a()
                    } else a()
                }, this)), a.queue($.proxy(function(a) {
                    this._show(this.options.fadeIn, function() {
                        a()
                    })
                }, this)), this.options.hideAfter && a.queue($.proxy(function() {
                    this.setActive()
                }, this))
            }
        },
        _show: function(a, b) {
            a = ("number" == $.type(a) ? a : this.options.fadeIn) || 0, b = b || ("function" == $.type(arguments[0]) ? arguments[0] : !1), this.options.hideOthers && Tooltips.hideAll(this), this._tooltip.fadeTo(a, 1, $.proxy(function() {
                b && b()
            }, this))
        },
        hideDelayed: function() {
            this.clearTimer("show"), this.getTimer("hide") || !this.visible() || this.is("disabled") || this.setTimer("hide", $.proxy(function() {
                this.clearTimer("hide"), this.hide()
            }, this), this.options.hideDelay || 1)
        },
        hide: function(a, b) {
            if (this.clearTimer("show"), this.visible() && !this.is("disabled")) {
                this.is("visible", !1), this.stop();
                var c = this.queues.showhide;
                c.queue($.proxy(function(b) {
                    this._hide(a, b)
                }, this)), c.queue(function(a) {
                    Tooltips.resetZ(), a()
                }), "function" == $.type(this.options.afterHide) && this.is("updated") && c.queue($.proxy(function(a) {
                    this.options.afterHide(this._content[0], this.element), a()
                }, this));
                var d = this.options.ajax;
                d && !d.cache && c.queue($.proxy(function(a) {
                    this.is("updated", !1), this.is("updating", !1), a()
                }, this)), "function" == $.type(b) && c.queue(function(a) {
                    b(), a()
                }), c.queue($.proxy(function(a) {
                    this.detach(), a()
                }, this))
            }
        },
        _hide: function(a, b) {
            b = b || ("function" == $.type(arguments[0]) ? arguments[0] : !1), this.attach(), this._tooltip.fadeTo(a ? 0 : this.options.fadeOut, 0, $.proxy(function() {
                this.options.ajax && this._cache.xhr && (this.abortAjax(), this.stopLoading()), this._tooltip.hide(), b && b()
            }, this))
        },
        toggle: function() {
            this.is("disabled") || this[this.visible() ? "hide" : "show"]()
        },
        raise: function() {
            if (this.is("build") && !this.options.zIndex) {
                var a = Tooltips.getHighestTooltip();
                a && a != this && this.zIndex <= a.zIndex && (this.zIndex = a.zIndex + 1, this._tooltip.css({
                    "z-index": this.zIndex
                }), this._tooltipShadow && (this._tooltipShadow.css({
                    "z-index": this.zIndex
                }), this.zIndex = a.zIndex + 2, this._tooltip.css({
                    "z-index": this.zIndex
                })))
            }
        }
    }), $.extend(Tooltip.prototype, {
        createElementMarker: function() {
            !this.elementMarker && this.content && _.element.isAttached(this.content) && ($(this.content).data("tpd-restore-inline-display", $(this.content).css("display")), this.elementMarker = $("<div>").hide(), $(this.content).before($(this.elementMarker).hide()))
        },
        restoreElementToMarker: function() {
            var a;
            this.content, this.elementMarker && this.content && ((a = $(this.content).data("tpd-restore-inline-display")) && $(this.content).css({
                display: a
            }), $(this.elementMarker).before(this.content).remove())
        },
        startLoading: function() {
            this.options.spinner && !this.is("loading") && (this.is("loading", !0), this._tooltip.addClass("tpd-is-loading"), this.skin.startLoading(), this.position(), this.raise(), this._show())
        },
        stopLoading: function() {
            this.options.spinner && this.is("loading") && (this.is("loading", !1), this._tooltip.removeClass("tpd-is-loading"), this.skin.stopLoading())
        },
        abortImageLoad: function() {
            this._cache.voila && (this._cache.voila.abort(), this._cache.voila = null)
        },
        abortAjax: function() {
            this._cache.xhr && (this._cache.xhr.abort(), this._cache.xhr = null, this.is("updated", !1), this.is("updating", !1))
        },
        update: function(a) {
            if (!this.is("updating") && !this.is("updating")) {
                this.is("updating", !0), this.build();
                var b = this.options.inline ? "inline" : this.options.ajax ? "ajax" : _.isElement(this.content) ? "element" : "function" == $.type(this.content) ? "function" : "html";
                switch (this._content.css({
                    visibility: "hidden"
                }), b) {
                    case "html":
                    case "element":
                    case "inline":
                        if (this.is("updated")) return a && a(), void 0;
                        this._update({
                            content: this.content,
                            title: this.title
                        }, a);
                        break;
                    case "function":
                        if (this.is("updated")) return a && a(), void 0;
                        var c = this.content.call(this.element);
                        if (!c) return this.is("updating", !1), a && a(!0), void 0;
                        this._update(c, a)
                }
            }
        },
        _update: function(a, b) {
            var c = {};
            c = "string" == $.type(a) || _.isElement(a) || a instanceof $ ? {
                content: a,
                title: !1
            } : a;
            var a = c.content,
                d = c.title;
            this.content = a, this.title = d, this.createElementMarker(), (_.isElement(a) || a instanceof $) && $(a).show(), this._content.html(this.content), this._title.html(d && "string" == $.type(d) ? d : ""), this._titleWrapper[d ? "show" : "hide"](), this._close[(this.title || this.options.title) && this.options.close ? "show" : "hide"]();
            var e = this.options.close,
                f = e && !(this.options.title || this.title),
                g = e && !(this.options.title || this.title) && "overlap" != e,
                h = e && (this.options.title || this.title) && "overlap" != e;
            this._inner_close[f ? "show" : "hide"](), this._tooltip[(g ? "add" : "remove") + "Class"]("tpd-has-inner-close"), this._tooltip[(h ? "add" : "remove") + "Class"]("tpd-has-title-close"), this._content[(this.options.padding ? "remove" : "add") + "Class"]("tpd-content-no-padding"), this.sanitizeContent($.proxy(function() {
                this.finishUpdate(b)
            }, this))
        },
        sanitizeContent: function(a) {
            return !$.fn.voila || !this.options.voila || this._content.find("img").length < 1 ? (a && a(), void 0) : (this.startLoading(), this._cache.voila = this._content.voila($.proxy(function() {
                this.stopLoading(), a && a()
            }, this)), void 0)
        },
        finishUpdate: function(a) {
            this.stopLoading(), this.visible() && this._content.css({
                visibility: "visible"
            }), this.is("updated", !0), this.is("updating", !1), "function" == $.type(this.options.afterUpdate) && this.options.afterUpdate(this._content[0], this.element), a && a()
        }
    }), $.extend(Tooltip.prototype, {
        updateDimensionsToContent: function(a, b) {
            var a = a || this.options.position.target,
                b = b || this.options.position.tooltip,
                c = this.skin._css.border;
            this._tooltip.addClass("tpd-tooltip-measuring");
            var d = this._tooltip.attr("style");
            this._tooltip.removeAttr("style");
            var e = {
                top: c,
                right: c,
                bottom: c,
                left: c
            };
            if (this.options.stem) {
                var f = 0;
                if ("vertical" == Position.getOrientation(b)) {
                    var g = Position.getSide(b);
                    e[g] = this.skin._vars.maxStemHeight;
                    var h = this.getContainmentLayout(b),
                        i = this.getPaddingLine(a),
                        j = !1;
                    Position.isPointWithinBoxLayout(i.x1, i.y1, h) || Position.isPointWithinBoxLayout(i.x2, i.y2, h) ? j = !0 : $.each("top right bottom left".split(" "), $.proxy(function(a, b) {
                        var c = this.getSideLine(h, b);
                        return Position.intersectsLine(i.x1, i.y1, i.x2, i.y2, c.x1, c.y1, c.x2, c.y2) ? (j = !0, !1) : void 0
                    }, this)), j && (f = "left" == g ? i.x1 - h.position.left : h.position.left + h.dimensions.width - i.x1, e[g] += f)
                }
            }
            if (this.options.offset && "horizontal" == Position.getOrientation(b)) {
                var k = Position.adjustOffsetBasedOnPosition(this.options.offset, this.options.position.target, a);
                0 !== k.x && (e.right += Math.abs(k.x))
            }
            var f;
            if (this.options.containment && (f = this.options.containment.padding)) {
                $.each(e, function(a) {
                    e[a] += f
                });
                var l = Position.getOrientation(b),
                    g = Position.getSide(b);
                "vertical" == l ? e["left" == g ? "right" : "left"] -= f : e["top" == g ? "bottom" : "top"] -= f
            }
            var m = Bounds.viewport(),
                n = this.options.close && !(this.options.title || this.title) && "overlap" != this.options.close,
                o = {
                    width: 0,
                    height: 0
                };
            n && (o = {
                width: this._inner_close.outerWidth(!0),
                height: this._inner_close.outerHeight(!0)
            }), this._contentRelativePadder.css({
                "padding-right": o.width + "px"
            }), this._contentSpacer.css({
                width: m.width - e.left - e.right + "px"
            });
            var p = {
                    width: this._content.innerWidth() + o.width,
                    height: Math.max(this._content.innerHeight(), o.height || 0)
                },
                q = {
                    width: 0,
                    height: 0
                };
            if (this.title) {
                var r = {
                    width: 0,
                    height: 0
                };
                this._titleWrapper.add(this._titleSpacer).css({
                    width: "auto",
                    height: "auto"
                }), this.options.close && "overlap" != this.options.close && (r = {
                    width: this._close.outerWidth(!0),
                    height: this._close.outerHeight(!0)
                }, this._close.hide()), this._maxWidthPass && p.width > this.options.maxWidth && this._titleRelative.css({
                    width: p.width + "px"
                }), this._titleRelativePadder.css({
                    "padding-right": r.width + "px"
                });
                var s = parseFloat(this._titleWrapper.css("border-bottom-width"));
                q = {
                    width: this.title ? this._titleWrapper.innerWidth() : 0,
                    height: Math.max(this.title ? this._titleWrapper.innerHeight() + s : 0, r.height + s)
                }, q.width > m.width - e.left - e.right && (q.width = m.width - e.left - e.right, this._titleSpacer.css({
                    width: q.width
                }), q.height = Math.max(this.title ? this._titleWrapper.innerHeight() + s : 0, r.height + s)), p.width = Math.max(q.width, p.width), p.height += q.height, this._titleWrapper.css({
                    height: Math.max(this.title ? this._titleWrapper.innerHeight() : 0, r.height) + "px"
                }), this.options.close && this._close.show()
            }
            if (this._contentSpacer.css({
                    width: p.width + "px"
                }), p.height != Math.max(this._content.innerHeight(), o.height) + (this.title ? this._titleRelative.outerHeight() : 0) && p.width++, this.is("loading") && (p = this.skin._css.loadingIcon.dimensions), this.setDimensions(p), e = {
                    top: c,
                    right: c,
                    bottom: c,
                    left: c
                }, this.options.stem) {
                var t = Position.getSide(b);
                e[t] = this.skin.stem_top.getMath().dimensions.outside.height
            }
            this._contentSpacer.css({
                "margin-top": e.top,
                "margin-left": +e.left,
                width: p.width
            }), (this.title || this.options.close) && this._titleWrapper.css({
                height: this._titleWrapper.innerHeight(),
                width: p.width
            }), this._tooltip.removeClass("tpd-tooltip-measuring"), this._tooltip.attr("style", d);
            var u = this._contentRelative.add(this._titleRelative);
            return this.options.maxWidth && p.width > this.options.maxWidth && !this._maxWidthPass && !this.is("loading") && (u.css({
                width: this.options.maxWidth
            }), this._maxWidthPass = !0, this.updateDimensionsToContent(a, b), this._maxWidthPass = !1, u.css({
                width: "auto"
            })), {
                content: p,
                title: q
            }
        },
        setDimensions: function(a) {
            this.skin.setDimensions(a)
        },
        getContainmentSpace: function(a, b) {
            var c = this.getContainmentLayout(a, b),
                d = this.getTargetLayout(),
                e = d.position,
                f = d.dimensions,
                g = c.position,
                h = c.dimensions,
                i = {
                    top: Math.max(e.top - g.top, 0),
                    bottom: Math.max(g.top + h.height - (e.top + f.height), 0),
                    left: Math.max(e.left - g.left, 0),
                    right: Math.max(g.left + h.width - (e.left + f.width), 0)
                };
            return e.top > g.top + h.height && (i.top -= e.top - (g.top + h.height)), e.top + f.height < g.top && (i.bottom -= g.top - (e.top + f.height)), e.left > g.left + h.width && g.left + h.width >= e.left && (i.left -= e.left - (g.left + h.width)), e.left + f.width < g.left && (i.right -= g.left - (e.left + f.width)), this._cache.layouts.containmentSpace = i, i
        },
        refresh: function() {
            this.is("build") && this.visible() && this.position()
        },
        position: function() {
            if (this.visible()) {
                this.is("positioning", !0), this._cache.layouts = {}, this._cache.dimensions;
                var a = this.options.position.target,
                    b = this.options.position.tooltip,
                    c = b,
                    d = a;
                this.updateDimensionsToContent(d, c);
                var e = this.getPositionBasedOnTarget(d, c),
                    f = deepExtend(e),
                    g = [];
                if (this.options.containment) {
                    var h = !1,
                        i = {};
                    if ($.each("top right bottom left".split(" "), $.proxy(function(a, b) {
                            (i[b] = this.isSideWithinContainment(b, c, !0)) && (h = !0)
                        }, this)), h || (f.contained = !0), f.contained) this.setPosition(f);
                    else {
                        g.unshift({
                            position: f,
                            targetPosition: d,
                            stemPosition: c
                        });
                        var j = Position.flip(a);
                        if (d = j, c = Position.flip(b), i[Position.getSide(d)] ? (this.updateDimensionsToContent(d, c), f = this.getPositionBasedOnTarget(d, c)) : f.contained = !1, f.contained) this.setPosition(f, c);
                        else {
                            g.unshift({
                                position: f,
                                targetPosition: d,
                                stemPosition: c
                            });
                            var k, l = a,
                                m = this.getContainmentSpace(c, !0),
                                n = "horizontal" == Position.getOrientation(l) ? ["left", "right"] : ["top", "bottom"];
                            k = m[n[0]] === m[n[1]] ? "horizontal" == Position.getOrientation(l) ? "left" : "top" : n[m[n[0]] > m[n[1]] ? 0 : 1];
                            var o = Position.split(l)[1],
                                p = k + o,
                                q = Position.flip(p);
                            if (d = p, c = q, i[Position.getSide(d)] ? (this.updateDimensionsToContent(d, c), f = this.getPositionBasedOnTarget(d, c)) : f.contained = !1, f.contained) this.setPosition(f, c);
                            else {
                                g.unshift({
                                    position: f,
                                    targetPosition: d,
                                    stemPosition: c
                                });
                                var r, s = [];
                                if ($.each(g, function(a, b) {
                                        if (b.position.top >= 0 && b.position.left >= 0) r = b;
                                        else {
                                            var c = b.position.top >= 0 ? 1 : Math.abs(b.position.top),
                                                d = b.position.left >= 0 ? 1 : Math.abs(b.position.left);
                                            s.push({
                                                result: b,
                                                negativity: c * d
                                            })
                                        }
                                    }), !r) {
                                    var t = s[s.length - 1];
                                    $.each(s, function(a, b) {
                                        b.negativity < t.negativity && (t = b)
                                    }), r = t.result
                                }
                                this.updateDimensionsToContent(r.targetPosition, r.stemPosition, !0), this.setPosition(r.position, r.stemPosition)
                            }
                        }
                    }
                } else this.setPosition(f);
                this._cache.dimensions = this.skin._vars.dimensions, this.is("positioning", !1)
            }
        },
        getPositionBasedOnTarget: function(a, b) {
            var b = b || this.options.position.tooltip,
                c = this.getTargetDimensions(),
                d = {
                    left: 0,
                    top: 0
                },
                e = {
                    left: 0,
                    top: 0
                };
            Position.getSide(a);
            var f = this.skin._vars,
                g = f.frames[Position.getSide(b)],
                h = Position.getOrientation(a),
                i = Position.split(a);
            if ("horizontal" == h) {
                var j = Math.floor(.5 * c.width);
                switch (i[2]) {
                    case "left":
                        e.left = j;
                        break;
                    case "middle":
                        d.left = c.width - j, e.left = d.left;
                        break;
                    case "right":
                        d.left = c.width, e.left = c.width - j
                }
                "bottom" == i[1] && (d.top = c.height, e.top = c.height)
            } else {
                var j = Math.floor(.5 * c.height);
                switch (i[2]) {
                    case "top":
                        e.top = j;
                        break;
                    case "middle":
                        d.top = c.height - j, e.top = d.top;
                        break;
                    case "bottom":
                        e.top = c.height - j, d.top = c.height
                }
                "right" == i[1] && (d.left = c.width, e.left = c.width)
            }
            var k = this.getTargetPosition(),
                l = $.extend({}, c, {
                    top: k.top,
                    left: k.left,
                    connection: d,
                    max: e
                }),
                m = {
                    width: g.dimensions.width,
                    height: g.dimensions.height,
                    top: 0,
                    left: 0,
                    connection: f.connections[b].connection,
                    stem: f.connections[b].stem
                };
            if (m.top = l.top + l.connection.top, m.left = l.left + l.connection.left, m.top -= m.connection.top, m.left -= m.connection.left, this.options.stem) {
                var n = f.stemDimensions.width,
                    o = {
                        stem: {
                            top: m.top + m.stem.connection.top,
                            left: m.left + m.stem.connection.left
                        },
                        connection: {
                            top: l.top + l.connection.top,
                            left: l.left + l.connection.left
                        },
                        max: {
                            top: l.top + l.max.top,
                            left: l.left + l.max.left
                        }
                    };
                if (!Position.isPointWithinBox(o.stem.left, o.stem.top, o.connection.left, o.connection.top, o.max.left, o.max.top)) {
                    var o = {
                            stem: {
                                top: m.top + m.stem.connection.top,
                                left: m.left + m.stem.connection.left
                            },
                            connection: {
                                top: l.top + l.connection.top,
                                left: l.left + l.connection.left
                            },
                            max: {
                                top: l.top + l.max.top,
                                left: l.left + l.max.left
                            }
                        },
                        p = {
                            connection: Position.getDistance(o.stem.left, o.stem.top, o.connection.left, o.connection.top),
                            max: Position.getDistance(o.stem.left, o.stem.top, o.max.left, o.max.top)
                        },
                        q = Math.min(p.connection, p.max),
                        r = o[p.connection <= p.max ? "connection" : "max"],
                        s = "horizontal" == Position.getOrientation(b) ? "left" : "top",
                        t = Position.getDistance(o.connection.left, o.connection.top, o.max.left, o.max.top);
                    if (t >= n) {
                        var u = {
                                top: 0,
                                left: 0
                            },
                            v = r[s] < o.stem[s] ? -1 : 1;
                        u[s] = q * v, u[s] += Math.floor(.5 * n) * v, m.left += u.left, m.top += u.top
                    } else {
                        $.extend(o, {
                            center: {
                                top: Math.round(l.top + .5 * c.height),
                                left: Math.round(l.left + .5 * c.left)
                            }
                        });
                        var w = {
                                connection: Position.getDistance(o.center.left, o.center.top, o.connection.left, o.connection.top),
                                max: Position.getDistance(o.center.left, o.center.top, o.max.left, o.max.top)
                            },
                            q = p[w.connection <= w.max ? "connection" : "max"],
                            x = {
                                top: 0,
                                left: 0
                            },
                            v = r[s] < o.stem[s] ? -1 : 1;
                        x[s] = q * v, m.left += x.left, m.top += x.top
                    }
                }
            }
            if (this.options.offset) {
                var y = $.extend({}, this.options.offset);
                y = Position.adjustOffsetBasedOnPosition(y, this.options.position.target, a), m.top += y.y, m.left += y.x
            }
            var z = this.getContainment({
                    top: m.top,
                    left: m.left
                }, b),
                A = z.horizontal && z.vertical,
                B = {
                    x: 0,
                    y: 0
                },
                C = Position.getOrientation(b);
            if (!z[C]) {
                var D = "horizontal" == C,
                    E = D ? ["left", "right"] : ["up", "down"],
                    F = D ? "x" : "y",
                    G = D ? "left" : "top",
                    H = z.correction[F],
                    I = this.getContainmentLayout(b),
                    J = I.position[D ? "left" : "top"];
                if (0 !== H) {
                    var K = f.connections[b].move,
                        L = K[E[0 > -1 * H ? 0 : 1]],
                        M = 0 > H ? -1 : 1;
                    if (L >= H * M && m[G] + H >= J) m[G] += H, B[F] = -1 * H, A = !0;
                    else if (Position.getOrientation(a) == Position.getOrientation(b)) {
                        if (m[G] += L * M, B[F] = -1 * L * M, m[G] < J) {
                            var N = J - m[G],
                                O = K[E[0]] + K[E[1]],
                                N = Math.min(N, O);
                            m[G] += N;
                            var P = B[F] - N;
                            P >= f.connections[b].move[E[0]] && P <= f.connections[b].move[E[1]] && (B[F] -= N)
                        }
                        z = this.getContainment({
                            top: m.top,
                            left: m.left
                        }, b);
                        var Q = z.correction[F],
                            R = deepExtend({}, m);
                        this.options.offset && (R.left -= this.options.offset.x, R.top -= this.options.offset.y);
                        var o = {
                            stem: {
                                top: R.top + m.stem.connection.top,
                                left: R.left + m.stem.connection.left
                            }
                        };
                        o.stem[G] += B[F];
                        var S = this.getTargetLayout(),
                            n = f.stemDimensions.width,
                            T = Math.floor(.5 * n),
                            U = J + I.dimensions[D ? "width" : "height"];
                        if ("x" == F) {
                            var V = S.position.left + T;
                            Q > 0 && (V += S.dimensions.width - 2 * T), (0 > Q && o.stem.left + Q >= V && R.left + Q >= J || Q > 0 && o.stem.left + Q <= V && R.left + Q <= U) && (R.left += Q)
                        } else {
                            var W = S.position.top + T;
                            Q > 0 && (W += S.dimensions.height - 2 * T), (0 > Q && o.stem.top + Q >= W && R.top + Q >= J || Q > 0 && o.stem.top + Q <= W && R.top + Q <= U) && (R.top += Q)
                        }
                        m = R, this.options.offset && (m.left += this.options.offset.x, m.top += this.options.offset.y)
                    }
                }
                z = this.getContainment({
                    top: m.top,
                    left: m.left
                }, b), A = z.horizontal && z.vertical
            }
            return {
                top: m.top,
                left: m.left,
                contained: A,
                shift: B
            }
        },
        setPosition: function(a, b) {
            var c = this._position;
            if (!c || c.top != a.top || c.left != a.left) {
                var d;
                if (this.options.container != document.body) {
                    if ("string" == $.type(this.options.container)) {
                        var e = this.target;
                        "mouse" == e && (e = this.element), d = $(e).closest(this.options.container).first()
                    } else d = $(d);
                    if (d[0]) {
                        var f = d.offset();
                        offset = {
                            top: Math.round(f.top),
                            left: Math.round(f.left)
                        }, scroll = {
                            top: Math.round(d.scrollTop()),
                            left: Math.round(d.scrollLeft())
                        }, a.top -= offset.top, a.top += scroll.top, a.left -= offset.left, a.left += scroll.left
                    }
                }
                this._position = a, this._tooltip.css({
                    top: a.top,
                    left: a.left
                })
            }
            this.skin.setStemPosition(b || this.options.position.tooltip, a.shift || {
                x: 0,
                y: 0
            })
        },
        getSideLine: function(a, b) {
            var c = a.position.left,
                d = a.position.top,
                e = a.position.left,
                f = a.position.top;
            switch (b) {
                case "top":
                    e += a.dimensions.width;
                    break;
                case "bottom":
                    d += a.dimensions.height, e += a.dimensions.width, f += a.dimensions.height;
                    break;
                case "left":
                    f += a.dimensions.height;
                    break;
                case "right":
                    c += a.dimensions.width, e += a.dimensions.width, f += a.dimensions.height
            }
            return {
                x1: c,
                y1: d,
                x2: e,
                y2: f
            }
        },
        isSideWithinContainment: function(a, b, c) {
            var d = this.getContainmentLayout(b, c),
                e = this.getTargetLayout(),
                f = this.getSideLine(e, a);
            if (Position.isPointWithinBoxLayout(f.x1, f.y1, d) || Position.isPointWithinBoxLayout(f.x2, f.y2, d)) return !0;
            var g = !1;
            return $.each("top right bottom left".split(" "), $.proxy(function(a, b) {
                var c = this.getSideLine(d, b);
                return Position.intersectsLine(f.x1, f.y1, f.x2, f.y2, c.x1, c.y1, c.x2, c.y2) ? (g = !0, !1) : void 0
            }, this)), g
        },
        getContainment: function(a, b) {
            var c = {
                horizontal: !0,
                vertical: !0,
                correction: {
                    y: 0,
                    x: 0
                }
            };
            if (this.options.containment) {
                var d = this.getContainmentLayout(b),
                    e = this.skin._vars.frames[Position.getSide(b)].dimensions;
                this.options.containment && ((a.left < d.position.left || a.left + e.width > d.position.left + d.dimensions.width) && (c.horizontal = !1, c.correction.x = a.left < d.position.left ? d.position.left - a.left : d.position.left + d.dimensions.width - (a.left + e.width)), (a.top < d.position.top || a.top + e.height > d.position.top + d.dimensions.height) && (c.vertical = !1, c.correction.y = a.top < d.position.top ? d.position.top - a.top : d.position.top + d.dimensions.height - (a.top + e.height)))
            }
            return c
        },
        getContainmentLayout: function(a, b) {
            var c = {
                    top: $(window).scrollTop(),
                    left: $(window).scrollLeft()
                },
                d = this.target;
            "mouse" == d && (d = this.element);
            var e, f = $(d).closest(this.options.containment.selector).first()[0];
            e = f && "viewport" != this.options.containment.selector ? {
                dimensions: {
                    width: $(f).innerWidth(),
                    height: $(f).innerHeight()
                },
                position: $(f).offset()
            } : {
                dimensions: Bounds.viewport(),
                position: c
            };
            var g = this.options.containment.padding;
            if (g && !b) {
                var h = Math.max(e.dimensions.height, e.dimensions.width);
                if (2 * g > h && (g = Math.max(Math.floor(.5 * h), 0)), g) {
                    e.dimensions.width -= 2 * g, e.dimensions.height -= 2 * g, e.position.top += g, e.position.left += g;
                    var i = Position.getOrientation(a);
                    "vertical" == i ? (e.dimensions.width += g, "left" == Position.getSide(a) && (e.position.left -= g)) : (e.dimensions.height += g, "top" == Position.getSide(a) && (e.position.top -= g))
                }
            }
            return this._cache.layouts.containmentLayout = e, e
        },
        getTargetPosition: function() {
            var a;
            if ("mouse" == this.options.target)
                if (this.is("api")) {
                    var b = $(this.element).offset();
                    a = {
                        top: Math.round(b.top),
                        left: Math.round(b.left)
                    }
                } else a = Mouse.getPosition(this._cache.event);
            else {
                var b = $(this.target).offset();
                a = {
                    top: Math.round(b.top),
                    left: Math.round(b.left)
                }
            }
            return this._cache.layouts.targetPosition = a, a
        },
        getTargetDimensions: function() {
            if (this._cache.layouts.targetDimensions) return this._cache.layouts.targetDimensions;
            var a;
            return a = "mouse" == this.options.target ? Mouse.getDimensions() : {
                width: $(this.target).innerWidth(),
                height: $(this.target).innerHeight()
            }, this._cache.layouts.targetDimensions = a, a
        },
        getTargetLayout: function() {
            if (this._cache.layouts.targetLayout) return this._cache.layouts.targetLayout;
            var a = {
                position: this.getTargetPosition(),
                dimensions: this.getTargetDimensions()
            };
            return this._cache.layouts.targetLayout = a, a
        },
        getPaddingLine: function(a) {
            var b = this.getTargetLayout(),
                c = "left";
            if ("vertical" == Position.getOrientation(a)) return this.getSideLine(b, Position.getSide(a));
            if (Position.isCorner(a)) {
                var d = Position.inverseCornerPlane(a);
                return c = Position.getSide(d), this.getSideLine(b, c)
            }
            var e = this.getSideLine(b, c),
                f = Math.round(.5 * b.dimensions.width);
            return e.x1 += f, e.x2 += f, e
        }
    }), $.extend(Tooltip.prototype, {
        setActive: function() {
            this.is("active", !0), this.visible() && this.raise(), this.options.hideAfter && this.clearTimer("idle")
        },
        setIdle: function() {
            this.is("active", !1), this.options.hideAfter && this.setTimer("idle", $.proxy(function() {
                this.clearTimer("idle"), this.is("active") || this.hide()
            }, this), this.options.hideAfter)
        }
    }), $.extend(Tooltip.prototype, {
        bind: function(a, b, c, d) {
            b = b;
            var e = $.proxy(c, d || this);
            this._cache.events.push({
                element: a,
                eventName: b,
                handler: e
            }), $(a).bind(b, e)
        },
        unbind: function() {
            $.each(this._cache.events, function(a, b) {
                $(b.element).unbind(b.eventName, b.handler)
            }), this._cache.events = []
        }
    }), $.extend(Tooltip.prototype, {
        disable: function() {
            this.is("disabled") || this.is("disabled", !0)
        },
        enable: function() {
            this.is("disabled") && this.is("disabled", !1)
        }
    }), $.extend(Tooltip.prototype, {
        is: function(a, b) {
            return "boolean" == $.type(b) && (this._cache.is[a] = b), this._cache.is[a]
        },
        visible: function() {
            return this.is("visible")
        }
    }), $.extend(Tooltip.prototype, {
        setTimer: function(a, b, c) {
            this._cache.timers[a] = _.delay(b, c)
        },
        getTimer: function(a) {
            return this._cache.timers[a]
        },
        clearTimer: function(a) {
            this._cache.timers[a] && (window.clearTimeout(this._cache.timers[a]), delete this._cache.timers[a])
        },
        clearTimers: function() {
            $.each(this._cache.timers, function(a, b) {
                window.clearTimeout(b)
            }), this._cache.timers = {}
        }
    }), $.extend(Tipped, {
        init: function() {
            Tooltips.init()
        },
        create: function(a, b, c) {
            return Collection.create(a, b, c), this.get(a)
        },
        get: function(a) {
            return new Collection(a)
        },
        findElement: function(a) {
            return Tooltips.findElement(a)
        },
        setStartingZIndex: function(a) {
            return Tooltips.setStartingZIndex(a), this
        }
    }), $.each("remove refresh".split(" "), function(a, b) {
        Tipped[b] = function(a) {
            return this.get(a)[b](), this
        }
    }), $.extend(Collection, {
        create: function(a, b) {
            if (a) {
                "object" == $.type(a) && (a = $(a)[0]);
                var c = arguments[2] || {};
                return _.isElement(a) ? new Tooltip(a, b, c) : $(a).each(function(a, d) {
                    new Tooltip(d, b, c)
                }), this
            }
        }
    }), $.extend(Collection.prototype, {
        items: function() {
            return Tooltips.get(this.element, {
                api: !0
            })
        },
        remove: function() {
            return Tooltips.remove(this.element), this
        }
    }), $.each("refresh".split(" "), function(a, b) {
        Collection.prototype[b] = function() {
            return $.each(this.items(), function(a, c) {
                c[b]()
            }), this
        }
    }), Tipped.init(), Tipped
}),
function(a) {
    "function" == typeof define && define.amd ? define(["jquery"], a) : jQuery && !window.Voila && (window.Voila = a(jQuery))
}(function(a) {
    function b(c, d, e) {
        if (!(this instanceof b)) return new b(c, d, e);
        var f = a.type(arguments[1]),
            g = "object" === f ? arguments[1] : {},
            h = "function" === f ? arguments[1] : "function" === a.type(arguments[2]) ? arguments[2] : !1;
        return this.options = a.extend({
            method: "naturalWidth"
        }, g), this.deferred = new jQuery.Deferred, h && this.always(h), this._processed = 0, this.images = [], this._add(c), this
    }
    a.extend(b.prototype, {
        _add: function(b) {
            var d = "string" == a.type(b) ? a(b) : b instanceof jQuery || b.length > 0 ? b : [b];
            a.each(d, a.proxy(function(b, d) {
                var e = a(),
                    f = a(d);
                e = f.is("img") ? e.add(f) : e.add(f.find("img")), e.each(a.proxy(function(b, d) {
                    this.images.push(new c(d, a.proxy(function(a) {
                        this._progress(a)
                    }, this), a.proxy(function(a) {
                        this._progress(a)
                    }, this), this.options))
                }, this))
            }, this)), this.images.length < 1 && setTimeout(a.proxy(function() {
                this._resolve()
            }, this))
        },
        abort: function() {
            this._progress = this._notify = this._reject = this._resolve = function() {}, a.each(this.images, function(a, b) {
                b.abort()
            }), this.images = []
        },
        _progress: function(a) {
            this._processed++, a.isLoaded || (this._broken = !0), this._notify(a), this._processed == this.images.length && this[this._broken ? "_reject" : "_resolve"]()
        },
        _notify: function(a) {
            this.deferred.notify(this, a)
        },
        _reject: function() {
            this.deferred.reject(this)
        },
        _resolve: function() {
            this.deferred.resolve(this)
        },
        always: function(a) {
            return this.deferred.always(a), this
        },
        done: function(a) {
            return this.deferred.done(a), this
        },
        fail: function(a) {
            return this.deferred.fail(a), this
        },
        progress: function(a) {
            return this.deferred.progress(a), this
        }
    }), a.fn.voila = function() {
        return b.apply(b, [this].concat(Array.prototype.slice.call(arguments)))
    };
    var c = function() {
        return this.initialize.apply(this, Array.prototype.slice.call(arguments))
    };
    return a.extend(c.prototype, {
        supports: {
            naturalWidth: function() {
                return "naturalWidth" in new Image
            }()
        },
        initialize: function(b, c, d) {
            return this.img = a(b)[0], this.successCallback = c, this.errorCallback = d, this.isLoaded = !1, this.options = a.extend({
                method: "naturalWidth",
                pollFallbackAfter: 1e3
            }, arguments[3] || {}), this.supports.naturalWidth && "onload" != this.options.method ? this.img.complete && "undefined" != a.type(this.img.naturalWidth) ? (setTimeout(a.proxy(function() {
                this.img.naturalWidth > 0 ? this.success() : this.error()
            }, this)), void 0) : (a(this.img).bind("error", a.proxy(function() {
                setTimeout(a.proxy(function() {
                    this.error()
                }, this))
            }, this)), this.intervals = [
                [1e3, 10],
                [2e3, 50],
                [4e3, 100],
                [2e4, 500]
            ], this._ipos = 0, this._time = 0, this._delay = this.intervals[this._ipos][1], this.poll(), void 0) : (setTimeout(a.proxy(this.fallback, this)), void 0)
        },
        poll: function() {
            this._polling = setTimeout(a.proxy(function() {
                if (this.img.naturalWidth > 0) return this.success(), void 0;
                if (this._time += this._delay, this.options.pollFallbackAfter && this._time >= this.options.pollFallbackAfter && !this._usedPollFallback && (this._usedPollFallback = !0, this.fallback()), this._time > this.intervals[this._ipos][0]) {
                    if (!this.intervals[this._ipos + 1]) return this.error(), void 0;
                    this._ipos++, this._delay = this.intervals[this._ipos][1]
                }
                this.poll()
            }, this), this._delay)
        },
        fallback: function() {
            var b = new Image;
            this._fallbackImg = b, b.onload = a.proxy(function() {
                b.onload = function() {}, this.supports.naturalWidth || (this.img.naturalWidth = b.width, this.img.naturalHeight = b.height), this.success()
            }, this), b.onerror = a.proxy(this.error, this), b.src = this.img.src
        },
        abort: function() {
            this._fallbackImg && (this._fallbackImg.onload = function() {}), this._polling && (clearTimeout(this._polling), this._polling = null)
        },
        success: function() {
            this._calledSuccess || (this._calledSuccess = !0, this.isLoaded = !0, this.successCallback(this))
        },
        error: function() {
            this._calledError || (this._calledError = !0, this.abort(), this.errorCallback && this.errorCallback(this))
        }
    }), b
});