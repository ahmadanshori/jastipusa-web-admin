/**
 * Currency Utility Functions for Indonesian Rupiah
 *
 * This utility provides functions for formatting Indonesian Rupiah currency
 * that can be used throughout the application.
 */

window.CurrencyUtils = {
    /**
     * Format number as Indonesian Rupiah currency
     * @param {number|string} amount - The amount to format
     * @param {object} options - Formatting options
     * @returns {string} Formatted Rupiah string
     */
    formatRupiah: function (amount, options = {}) {
        // Default options
        const defaults = {
            prefix: "Rp ",
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
            showDecimals: false,
        };

        // Merge options with defaults
        const config = Object.assign(defaults, options);

        // Parse the amount to number
        const number = parseFloat(amount) || 0;

        // Format using Indonesian locale
        const formatted = number.toLocaleString("id-ID", {
            minimumFractionDigits: config.showDecimals
                ? 2
                : config.minimumFractionDigits,
            maximumFractionDigits: config.showDecimals
                ? 2
                : config.maximumFractionDigits,
        });

        return config.prefix + formatted;
    },

    /**
     * Format number as Rupiah for DataTables render function
     * @param {number|string} data - The data to format
     * @param {string} type - DataTables render type
     * @param {object} row - DataTables row data
     * @param {object} options - Formatting options
     * @returns {string|number} Formatted string for display, original data otherwise
     */
    formatRupiahForDataTable: function (data, type, row, options = {}) {
        if (type === "display" || type === "type") {
            return this.formatRupiah(data, options);
        }
        return data;
    },

    /**
     * Parse Rupiah string back to number
     * @param {string} rupiahString - Formatted Rupiah string
     * @returns {number} Parsed number
     */
    parseRupiah: function (rupiahString) {
        if (typeof rupiahString !== "string") {
            return parseFloat(rupiahString) || 0;
        }

        // Remove Rp prefix and dots, replace comma with dot for decimals
        const cleaned = rupiahString
            .replace(/Rp\s?/g, "")
            .replace(/\./g, "")
            .replace(/,/g, ".");

        return parseFloat(cleaned) || 0;
    },

    /**
     * Format number with thousands separator (no currency symbol)
     * @param {number|string} amount - The amount to format
     * @param {object} options - Formatting options
     * @returns {string} Formatted number string
     */
    formatNumber: function (amount, options = {}) {
        const defaults = {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        };

        const config = Object.assign(defaults, options);
        const number = parseFloat(amount) || 0;

        return number.toLocaleString("id-ID", config);
    },

    /**
     * Format as short currency (K, M, B for thousands, millions, billions)
     * @param {number|string} amount - The amount to format
     * @param {object} options - Formatting options
     * @returns {string} Formatted short currency string
     */
    formatShortRupiah: function (amount, options = {}) {
        const defaults = {
            prefix: "Rp ",
            precision: 1,
        };

        const config = Object.assign(defaults, options);
        const number = parseFloat(amount) || 0;

        if (number >= 1000000000) {
            return (
                config.prefix +
                (number / 1000000000).toFixed(config.precision) +
                "M"
            );
        } else if (number >= 1000000) {
            return (
                config.prefix +
                (number / 1000000).toFixed(config.precision) +
                "Jt"
            );
        } else if (number >= 1000) {
            return (
                config.prefix + (number / 1000).toFixed(config.precision) + "K"
            );
        }

        return this.formatRupiah(number, { prefix: config.prefix });
    },

    /**
     * Validate if string is a valid Rupiah format
     * @param {string} rupiahString - String to validate
     * @returns {boolean} True if valid Rupiah format
     */
    isValidRupiah: function (rupiahString) {
        if (typeof rupiahString !== "string") {
            return false;
        }

        // Check if it matches Rupiah pattern
        const rupiahPattern = /^Rp\s?\d{1,3}(\.\d{3})*(\,\d{2})?$/;
        return rupiahPattern.test(rupiahString);
    },

    /**
     * Format number as US Dollar currency
     * @param {number|string} amount - The amount to format
     * @param {object} options - Formatting options
     * @returns {string} Formatted Dollar string
     */
    formatDollar: function (amount, options = {}) {
        // Default options
        const defaults = {
            prefix: "$",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
            showDecimals: true,
        };

        // Merge options with defaults
        const config = Object.assign(defaults, options);

        // Parse the amount to number
        const number = parseFloat(amount) || 0;

        // Format using US locale
        const formatted = number.toLocaleString("en-US", {
            minimumFractionDigits: config.showDecimals
                ? 2
                : config.minimumFractionDigits,
            maximumFractionDigits: config.showDecimals
                ? 2
                : config.maximumFractionDigits,
        });

        return config.prefix + formatted;
    },

    /**
     * Format number as Dollar for DataTables render function
     * @param {number|string} data - The data to format
     * @param {string} type - DataTables render type
     * @param {object} row - DataTables row data
     * @param {object} options - Formatting options
     * @returns {string|number} Formatted string for display, original data otherwise
     */
    formatDollarForDataTable: function (data, type, row, options = {}) {
        if (type === "display" || type === "type") {
            return this.formatDollar(data, options);
        }
        return data;
    },

    /**
     * Parse Dollar string back to number
     * @param {string} dollarString - Formatted Dollar string
     * @returns {number} Parsed number
     */
    parseDollar: function (dollarString) {
        if (typeof dollarString !== "string") {
            return parseFloat(dollarString) || 0;
        }

        // Remove $ prefix and commas
        const cleaned = dollarString.replace(/\$\s?/g, "").replace(/,/g, "");

        return parseFloat(cleaned) || 0;
    },

    /**
     * Format as short Dollar currency (K, M, B for thousands, millions, billions)
     * @param {number|string} amount - The amount to format
     * @param {object} options - Formatting options
     * @returns {string} Formatted short Dollar string
     */
    formatShortDollar: function (amount, options = {}) {
        const defaults = {
            prefix: "$",
            precision: 1,
        };

        const config = Object.assign(defaults, options);
        const number = parseFloat(amount) || 0;

        if (number >= 1000000000) {
            return (
                config.prefix +
                (number / 1000000000).toFixed(config.precision) +
                "B"
            );
        } else if (number >= 1000000) {
            return (
                config.prefix +
                (number / 1000000).toFixed(config.precision) +
                "M"
            );
        } else if (number >= 1000) {
            return (
                config.prefix + (number / 1000).toFixed(config.precision) + "K"
            );
        }

        return this.formatDollar(number, { prefix: config.prefix });
    },

    /**
     * Validate if string is a valid Dollar format
     * @param {string} dollarString - String to validate
     * @returns {boolean} True if valid Dollar format
     */
    isValidDollar: function (dollarString) {
        if (typeof dollarString !== "string") {
            return false;
        }

        // Check if it matches Dollar pattern
        const dollarPattern = /^\$\s?\d{1,3}(,\d{3})*(\.\d{2})?$/;
        return dollarPattern.test(dollarString);
    },
};

// Alternative global functions for convenience
window.formatRupiah = function (amount, options) {
    return window.CurrencyUtils.formatRupiah(amount, options);
};

window.formatDollar = function (amount, options) {
    return window.CurrencyUtils.formatDollar(amount, options);
};

// jQuery plugin for easy integration
if (typeof jQuery !== "undefined") {
    jQuery.fn.formatRupiah = function (options) {
        return this.each(function () {
            const $this = jQuery(this);
            const value = $this.text() || $this.val();
            const formatted = window.CurrencyUtils.formatRupiah(value, options);

            if ($this.is("input")) {
                $this.val(formatted);
            } else {
                $this.text(formatted);
            }
        });
    };

    jQuery.fn.formatDollar = function (options) {
        return this.each(function () {
            const $this = jQuery(this);
            const value = $this.text() || $this.val();
            const formatted = window.CurrencyUtils.formatDollar(value, options);

            if ($this.is("input")) {
                $this.val(formatted);
            } else {
                $this.text(formatted);
            }
        });
    };
}
