/**
 * Accordion / FAQ-style toggles (same behavior as the former faqs module script).
 * Uses delegation so all .toggle-trigger buttons work, including the Toggles flexible module.
 */
(function () {
    var imagesLayoutMobileQuery = window.matchMedia('(max-width: 64.0625em)');

    document.addEventListener('click', function (e) {
        var trigger = e.target.closest('.toggle-trigger');
        if (!trigger) {
            return;
        }

        var module = trigger.closest('.toggles');
        var isImagesLayout =
            module && module.getAttribute('data-layout') === 'images';
        var answerId = trigger.getAttribute('aria-controls');
        if (!answerId) {
            return;
        }

        if (isImagesLayout && imagesLayoutMobileQuery.matches) {
            var toggle = trigger.closest('.toggle');
            var mobileAnswer = toggle
                ? toggle.querySelector('.toggle-detail-panel-wrap--mobile')
                : null;
            var desktopAnswer = document.getElementById(answerId);
            var isExpanded = trigger.getAttribute('aria-expanded') === 'true';
            var shouldOpen = !isExpanded;

            if (!mobileAnswer) {
                return;
            }

            trigger.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false');
            mobileAnswer.setAttribute(
                'aria-hidden',
                shouldOpen ? 'false' : 'true'
            );

            if (desktopAnswer) {
                desktopAnswer.setAttribute(
                    'aria-hidden',
                    shouldOpen ? 'false' : 'true'
                );
            }

            return;
        }

        var answer = document.getElementById(answerId);
        if (!answer) {
            return;
        }

        if (isImagesLayout) {
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

            answers.forEach(function (item) {
                if (item.getAttribute('data-mobile-answer-for') === answerId) {
                    item.setAttribute('aria-hidden', 'false');
                }
            });
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
