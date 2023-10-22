// custom from https://github.com/1player/oddslib

const ODDS_HELPER = {
    decimalAdjust: function (type, value, exp) {
        // If the exp is undefined or zero...
        if (typeof exp === "undefined" || +exp === 0) {
            return Math[type](value);
        }
        value = +value;
        exp = +exp;
        // If the value is not a number or the exp is not an integer...
        if (isNaN(value) || !(typeof exp === "number" && exp % 1 === 0)) {
            return NaN;
        }
        // If the value is negative...
        if (value < 0) {
            return -this.decimalAdjust(type, -value, exp);
        }
        // Shift
        value = value.toString().split("e");
        value = Math[type](+(value[0] + "e" + (value[1] ? +value[1] - exp : -exp)));
        // Shift back
        value = value.toString().split("e");
        return +(value[0] + "e" + (value[1] ? +value[1] + exp : exp));
    },
    fixFloatError: function (n) {
        return parseFloat(n.toPrecision(12));
    },
    fractional: {
        approximate: function(d, precision) {
            var numerators = [0, 1];
            var denominators = [1, 0];

            var maxNumerator = this.getMaxNumerator(d);
            var d2 = d;
            var calcD,
                prevCalcD = NaN;

            var acceptableError = Math.pow(10, -precision) / 2;

            for (var i = 2; i < 1000; i++) {
                var L2 = Math.floor(d2);
                numerators[i] = L2 * numerators[i - 1] + numerators[i - 2];
                if (Math.abs(numerators[i]) > maxNumerator) return;

                denominators[i] = L2 * denominators[i - 1] + denominators[i - 2];

                calcD = numerators[i] / denominators[i];

                if (Math.abs(calcD - d) < acceptableError || calcD == prevCalcD) {
                    return numerators[i].toString() + "/" + denominators[i].toString();
                }

                d2 = 1 / (d2 - L2);
            }
        },
        getMaxNumerator: function (f) {
            var f2 = null;
            var ixe = f.toString().indexOf("E");
            if (ixe == -1) ixe = f.toString().indexOf("e");
            if (ixe == -1) f2 = f.toString();
            else f2 = f.toString().substring(0, ixe);

            var digits = null;
            var ix = f2.toString().indexOf(".");
            if (ix == -1) digits = f2;
            else if (ix === 0) digits = f2.substring(1, f2.length);
            else if (ix < f2.length)
                digits = f2.substring(0, ix) + f2.substring(ix + 1, f2.length);

            var L = digits;

            var numDigits = L.toString().length;
            var L2 = f;
            var numIntDigits = L2.toString().length;
            if (L2 === 0) numIntDigits = 0;
            var numDigitsPastDecimal = numDigits - numIntDigits;

            var i;
            for (i = numDigitsPastDecimal; i > 0 && L % 2 === 0; i--) L /= 2;
            for (i = numDigitsPastDecimal; i > 0 && L % 5 === 0; i--) L /= 5;

            return L;
        }
    },
    formats: {
        // European/Decimal format
        decimal: {
            from: function (decimal) {
                decimal = parseFloat(decimal);
                if (decimal <= 1.0) {
                return 'N/A';
                }
                return decimal;
            },
            to: function () {
                return this.decimalValue;
            },
        },

        // American/Moneyline format
        moneyline: {
            from: function (moneyline) {
                moneyline = parseFloat(moneyline);

                if (moneyline >= 0) {
                return moneyline / 100.0 + 1;
                }
                return 100 / -moneyline + 1;
            },
            to: function () {
                if (this.decimalValue >= 2) {
                return ODDS_HELPER.fixFloatError((this.decimalValue - 1) * 100.0);
                }
                return ODDS_HELPER.fixFloatError(-100 / (this.decimalValue - 1));
            },
        },

        // Hong Kong format
        hongkong: {
            from: function (hongKong) {
                hongKong = parseFloat(hongKong);
                if (hongKong < 0.0) {
                return 'N/A';
                }
                return hongKong + 1.0;
            },
            to: function () {
                return ODDS_HELPER.fixFloatError(this.decimalValue - 1);
            },
        },

        // Implied probability
        impliedProbability: {
            from: function (ip) {
                // Handle percentage string
                if (typeof ip === "string" && ip.slice(-1) == "%") {
                    ip = parseFloat(ip) / 100.0;
                } else {
                    ip = parseFloat(ip);
                }

                if (ip <= 0.0 || ip >= 1.0) {
                    return 'N/A';
                }

                return 1.0 / ip;
            },
            to: function (options) {
                if (options.percentage) {
                    var value = ODDS_HELPER.fixFloatError(100.0 / this.decimalValue);

                    if (options.precision !== null) {
                        value = ODDS_HELPER.decimalAdjust("round", value, -options.precision);
                    }

                    return value.toString() + "%";
                }

                return ODDS_HELPER.fixFloatError(1 / this.decimalValue);
            },
        },
        // Malay format
        malay: {
            from: function (malay) {
                malay = parseFloat(malay);

                if (malay <= -1.0 || malay > 1.0) {
                    return 'N/A';
                }

                if (malay < 0) {
                    malay = -1 / malay;
                }
                return malay + 1;
            },
            to: function () {
                if (this.decimalValue <= 2.0) {
                    return ODDS_HELPER.fixFloatError(this.decimalValue - 1);
                }
                return ODDS_HELPER.fixFloatError(-1 / (this.decimalValue - 1));
            },
        },

        // Indonesian format
        indonesian: {
            from: function (indonesian) {
                indonesian = parseFloat(indonesian);

                if (indonesian === 0) {
                    return 'N/A';
                }

                if (indonesian >= 1) {
                    return indonesian + 1;
                }

                return -1 / indonesian + 1;
            },
            to: function () {
                if (this.decimalValue < 2.0) {
                    return ODDS_HELPER.fixFloatError(-1 / (this.decimalValue - 1));
                }

                return ODDS_HELPER.fixFloatError(this.decimalValue - 1);
            },
        },

        // UK/Fractional format
        fractional: {
            from: function (n) {
                // Try to split on the slash
                var pieces = n.toString().split("/");

                n = parseFloat(pieces[0]);

                var d;
                if (pieces.length === 2) {
                    d = parseFloat(pieces[1]);
                } else if (pieces.length === 1) {
                    d = 1;
                } else {
                    throw new Error("Invalid fraction");
                }

                if (n === 0 || d === 0 || n / d <= 0.0) {
                    return 'N/A';
                }

                return 1 + n / d;
            },
            to: function (options) {
                return ODDS_HELPER.fractional.approximate(this.decimalValue - 1, options.precision);
            },
        },
    },
}
let oddsConverter = {
    decimalValue: 0,
    from: function (format, value) {
        if (!ODDS_HELPER.formats.hasOwnProperty(format)) {
            throw new Error("Unknown format " + format + ".");
        }

        var decimal = ODDS_HELPER.formats[format].from(value);

        this.decimalValue = decimal;

        return {...this};
    },
    to: function(format, options) {
        if (! ODDS_HELPER.formats.hasOwnProperty(format)) {
            throw new Error("Unknown format " + format + ".");
        }

        options = Object.assign({
            precision: 2,
            percentage: false,
        }, options);

        var ret = ODDS_HELPER.formats[format].to.call(this, options);

        if (typeof ret === "number" && options.precision !== null) {
            ret = ODDS_HELPER.decimalAdjust("round", ret, -options.precision);
        }

        return ret;
    }
};

let odds_converter = function(value, format = 'decimal') {
    return oddsConverter.from(format, value);
}
