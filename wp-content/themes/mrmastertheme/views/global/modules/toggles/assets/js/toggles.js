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

        var module = trigger.closest('.toggles');
        var answerId = trigger.getAttribute('aria-controls');
        if (!answerId) {
            return;
        }

        var answer = document.getElementById(answerId);
        if (!answer) {
            return;
        }

        if (module && module.getAttribute('data-layout') === 'images') {
            if (trigger.getAttribute('aria-expanded') === 'true') {
                return;
            }

            var triggers = module.querySelectorAll('.toggle-trigger');
            var answers = module.querySelectorAll('.answer');

            triggers.forEach(function (item) {
                item.setAttribute('aria-expanded', 'false');
            });

            answers.forEach(function (item) {
                item.setAttribute('aria-hidden', 'true');
            });

            trigger.setAttribute('aria-expanded', 'true');
            answer.setAttribute('aria-hidden', 'false');
            return;
        }

        if (trigger.getAttribute('aria-expanded') === 'false') {
            trigger.setAttribute('aria-expanded', 'true');
        } else if (trigger.getAttribute('aria-expanded') === 'true') {
            trigger.setAttribute('aria-expanded', 'false');
        }

        if (answer.getAttribute('aria-hidden') === 'false') {
            answer.setAttribute('aria-hidden', 'true');
        } else if (answer.getAttribute('aria-hidden') === 'true') {
            answer.setAttribute('aria-hidden', 'false');
        }
    });
})();
