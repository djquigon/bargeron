/**
 * Accordion / FAQ-style toggles (same behavior as the former faqs module script).
 * Uses delegation so all .toggle-trigger buttons work, including the Toggles flexible module.
 */
(function () {
    document.addEventListener('click', function (e) {
        var trigger = e.target.closest('.toggle-trigger');
        if (!trigger) {
            return;
        }

        if (trigger.getAttribute('aria-expanded') === 'false') {
            trigger.setAttribute('aria-expanded', 'true');
        } else if (trigger.getAttribute('aria-expanded') === 'true') {
            trigger.setAttribute('aria-expanded', 'false');
        }

        var answerId = trigger.getAttribute('aria-controls');
        if (!answerId) {
            return;
        }

        var answer = document.getElementById(answerId);
        if (!answer) {
            return;
        }

        if (answer.getAttribute('aria-hidden') === 'false') {
            answer.setAttribute('aria-hidden', 'true');
        } else if (answer.getAttribute('aria-hidden') === 'true') {
            answer.setAttribute('aria-hidden', 'false');
        }
    });
})();
