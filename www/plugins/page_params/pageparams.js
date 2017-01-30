/*!
 * Page_params_XH
 *
 * @author    Martin Damken <kontakt@zeichenkombinat.de>
 * @author    The CMSimple_XH developers <devs@cmsimple-xh.org>
 * @copyright 2009-2016 The CMSimple_XH developers
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link      http://cmsimple-xh.org/
 */

(function () {
    "use strict";

    /**
     * Registers an event listener.
     *
     * @param {EventTarget} target
     * @param {string}      event
     * @param {Function}    listener
     *
     * @returns {undefined}
     */
    function on(target, event, listener) {
        if (typeof target.addEventListener !== "undefined") {
            target.addEventListener(event, listener, false);
        } else if (typeof target.attachEvent !== "undefined") {
            target.attachEvent("on" + event, listener);
        }
    }

    /**
     * Toggles the disabled property.
     *
     * @param {Element} element
     *
     * @returns {undefined}
     */
    function toggle(element) {
        element.disabled = !element.disabled;
    }

    /**
     * Handles show_heading click events.
     *
     * @param {Event} event
     *
     * @returns {undefined}
     */
    function onShowHeadingClick(event) {
        var target = event.target || event.srcElement;

        toggle(target.form.elements.heading);
    }

    /**
     * Handles published click events.
     *
     * @param {Event} event
     *
     * @returns {undefined}
     */
    function onPublishedClick(event) {
        var target = event.target || event.srcElement;

        toggle(target.form.elements.publication_date);
        toggle(target.form.elements.expires);
    }

    /**
     * Handles change events of date fields.
     *
     * We're checking for plausibility of the input, and show an error message
     * otherwise.
     *
     * @param {Event} event
     *
     * @returns {undefined}
     */
    function onDateChange(event) {
        var field, datearr, dateformat, timeformat;

        field = event.target || event.srcElement;
        datearr = field.value.split(" ");
        dateformat = /^\d{4}[\-](0?[1-9]|1[012])[\-](0?[1-9]|[12][0-9]|3[01])$/;
        timeformat = /^([01]?[0-9]|2[0-3)])[:]([0-5]?[0-9])$/;

        if (datearr[0] === "" || datearr[0] === undefined) {
            datearr[0] = "2099-12-31";
        }
        if (datearr[1] === "" || datearr[1] === undefined) {
            datearr[1] = "00:00";
        }
        if (dateformat.test(datearr[0]) && timeformat.test(datearr[1])) {
            field.style.backgroundColor = "";
            field.style.color = "";
        } else {
            field.style.backgroundColor = "#ffe4e1";
            field.style.color = "#000";
            window.alert(PAGEPARAMS.message);
        }
    }

    /**
     * Handles use_header_location radio click events.
     *
     * @param {Event} event
     *
     * @returns {undefined}
     */
    function onHeaderLocationRadioClick(event) {
        var target = event.target || event.srcElement,
            disabled = (target.value === "0");

        target.form.elements.header_location.disabled = disabled;
        document.getElementById("pageparams_linklist").disabled = disabled;
    }

    /**
     * Handles pageparams_linklist change events.
     *
     * @param {Event} event
     *
     * @returns {undefined}
     */
    function onLinkListChange(event) {
        var target, input;

        target = event.target || event.srcElement;
        input = target.form.elements.header_location;
        input.value = target.value ? "?" + target.value : "";
    }

    /*
     * Register the event handlers.
     */
    on(window, "load", function () {
        var form, elements, element, i;

        form = document.getElementById("page_params");
        if (form) {
            elements = form.elements;
            on(elements.show_heading[1], "click", onShowHeadingClick);
            on(elements.published[1], "click", onPublishedClick);
            on(elements.publication_date, "change", onDateChange);
            on(elements.expires, "change", onDateChange);
            elements = form.elements.use_header_location;
            for (i = 0; i < elements.length; i += 1) {
                on(elements[i], "click", onHeaderLocationRadioClick);
            }
        }
        element = document.getElementById("pageparams_linklist");
        if (element) {
            on(element, "change", onLinkListChange);
        }
    });
}());
