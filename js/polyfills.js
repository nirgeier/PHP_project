/**
 * Polyfill.
 * Here i added the function that im using in th code and might not be supported in all browsers.
 */
Array.isArray = Array.isArray ||
    function (arg) {
        return Object.prototype.toString.call(arg) === "[object Array]";
    };

Array.prototype.forEach = Array.prototype.forEach ||
    function (fn, scope) {
        for (var i = 0, len = this.length; i < len; ++i) {
            fn.call(scope || this, this[i], i, this);
        }
    }

Object.keys = Object.keys ||
    (function () {
        var hasOwnProperty = Object.prototype.hasOwnProperty,
            hasDontEnumBug = !({toString:null}).propertyIsEnumerable('toString'),
            dontEnums = [
                'toString',
                'toLocaleString',
                'valueOf',
                'hasOwnProperty',
                'isPrototypeOf',
                'propertyIsEnumerable',
                'constructor'
            ];

        return function (obj) {
            var result = []

            if (typeof obj !== 'object' && typeof obj !== 'function' || obj === null) {
                throw new TypeError('Object.keys called on non-object');
            }

            for (var prop in obj) {
                if (hasOwnProperty.call(obj, prop)) {
                    result.push(prop);
                }
            }

            // Cool hack :-)
            if (hasDontEnumBug) {
                dontEnums.forEach(function (element, index, array) {
                    if (hasOwnProperty.call(obj, dontEnums[i])) {
                        result.push(dontEnums[i]);
                    }
                });
            }
            return result
        }
    })();

Function.prototype.bind = Function.prototype.bind || function (oThis) {
    if (typeof this !== "function") {
        // closest thing possible to the ECMAScript 5 internal IsCallable function
        throw new TypeError("Function.prototype.bind - what is trying to be bound is not callable");
    }

    var aArgs = Array.prototype.slice.call(arguments, 1),
        fToBind = this,
        fNOP = function () {
        },
        fBound = function () {
            return fToBind.apply(this instanceof fNOP && oThis
                ? this
                : oThis,
                aArgs.concat(Array.prototype.slice.call(arguments)));
        };

    fNOP.prototype = this.prototype;
    fBound.prototype = new fNOP();

    return fBound;
}
