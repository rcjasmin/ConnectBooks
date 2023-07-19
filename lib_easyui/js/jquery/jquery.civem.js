/**
 * jQuery Plugin CIVEM v0.0.1
 * A jQuery plugin to Custom Input Validation Error Messages
 * 2012, Javier Espinosa <mail@javespi.com>
 *
 * Fork of http://github.com/javanto/civem.js (v 0.0.4)
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */

(function( $ ){

  $.fn.civem = function() {
    if ($(this).prop('tagName') != "FORM")
        throw new Error('civem: Custom validation is not supported in ' + $(this).prop('tagName') + ' elements.');

    this.find('input, textarea, select').each(function(i, formElement) {
	    if (!formElement.willValidate)
		    return true;

	    if (formElement.oninput){
		    var inputCallback = formElement.oninput;
	    }
	    formElement.oninput = function(event) {
		    event.target.setCustomValidity("");
		    if (inputCallback)
			    inputCallback(event);
	    };

	    if (formElement.oninvalid)
		    var invalidCallback = formElement.oninvalid;
	    else formElement.oninvalid = function(event) {
		    var element  = event.target;
		    var validity = element.validity;
		    var suffix   = validity.valueMissing    ? "value-missing"    :
		                   validity.typeMismatch    ? "type-mismatch"    :
		                   validity.patternMismatch ? "pattern-mismatch" :
		                   validity.tooLong         ? "too-long"         :
		                   validity.rangeUnderflow  ? "range-underflow"  :
		                   validity.rangeOverflow   ? "range-overflow"   :
		                   validity.stepMismatch    ? "step-mismatch"    :
		                   validity.customError     ? "custom-error"     : "";
		    var specificErrormessage, genericErrormessage;
		    if (suffix && (specificErrormessage = element.getAttribute("data-errormessage-" + suffix)))
			    element.setCustomValidity(specificErrormessage);
		    else if (genericErrormessage = element.getAttribute("data-errormessage"))
			    element.setCustomValidity(genericErrormessage);
		    else
			    element.setCustomValidity(element.validationMessage);
		    if (invalidCallback)
			    invalidCallback(event);
	    }
    });
  };
})( jQuery );
