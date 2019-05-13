'use strict';
var textInputs = document.querySelectorAll('input');
textInputs.forEach((textInput) => {
    styleInput(textInput);
});

function styleInput(textInput) {
    if (typeof textInput === 'undefined')
        return;

    var inputWrap = textInput.parentElement;
    var inputWidth = parseInt(getComputedStyle(inputWrap).width);
    var svgText = Snap(inputWrap.parentElement.getElementsByClassName("line")[0]);
    var qCurve = inputWidth / 2;  // For correct curving on diff screen sizes
    var textPath = svgText.path("M0 0 " + inputWidth + " 0");
    var textDown = function () {
        textPath.animate({ d: "M0 0 Q" + qCurve + " 40 " + inputWidth + " 0" }, 150, mina.easeout);
    };
    var textUp = function () {
        textPath.animate({ d: "M0 0 Q" + qCurve + " -30 " + inputWidth + " 0" }, 150, mina.easeout);
    };
    var textSame = function () {
        textPath.animate({ d: "M0 0 " + inputWidth + " 0" }, 200, mina.easein);
    };

    Object.defineProperty(textInput, 'textRun', {
        value: function () {
            setTimeout(textDown, 200);
            setTimeout(textUp, 400);
            setTimeout(textSame, 600);
        },
        configurable: true
    });

    (function () {
        textInput.addEventListener('focus', function () {
            animateInput(this);
        });
    })();
}

function animateInput(elem) {
    var parentDiv = elem.parentElement;
    parentDiv.classList.add('active');
    elem.textRun();
    var rg = new RegExp(elem.dataset.validator);
    elem.addEventListener('blur', function () {
        elem.value == 0 ? parentDiv.classList.remove('active') : null;
        !rg.test(elem.value) && elem.value != 0 ?
            (parentDiv.classList.remove('valid'), parentDiv.classList.add('invalid'), parentDiv.style.transformOrigin = "center")
            : rg.test(elem.value) && elem.value != 0 ?
                (parentDiv.classList.add('valid'), parentDiv.classList.remove('invalid'), parentDiv.style.transformOrigin = "bottom") : null;
    });
    parentDiv.classList.remove('valid', 'invalid')
}