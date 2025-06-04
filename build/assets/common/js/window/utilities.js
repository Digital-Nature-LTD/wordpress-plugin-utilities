window.DigitalNature = window.DigitalNature || {};

window.DigitalNature.utils = {
    request: {
        get: async function (url) {
            // Default options are marked with *
            const response = await fetch(url, {
                method: "GET", // *GET, POST, PUT, DELETE, etc.
                mode: "cors",
                cache: "no-cache",
                credentials: "same-origin",
                headers: {
                    "Content-Type": "application/json",
                    "X-WP-Nonce": wpApiSettings.nonce
                },
                redirect: "follow",
                referrerPolicy: "no-referrer",
            });

            return response.json();
        },
        post: async function (url, data = {}) {
            // Default options are marked with *
            const response = await fetch(url, {
                method: "POST", // *GET, POST, PUT, DELETE, etc.
                mode: "cors",
                cache: "no-cache",
                credentials: "same-origin",
                headers: {
                    "Content-Type": "application/json",
                    "X-WP-Nonce": wpApiSettings.nonce
                },
                redirect: "follow",
                referrerPolicy: "no-referrer",
                body: JSON.stringify(data),
            });

            return response.json();
        },
        params: {
            get(param) {
                const urlParams = new URLSearchParams(window.location.search)
                return urlParams.get(param)
            }
        }
    },


    dragTable: {
        row: null,

        init: function () {
            document.addEventListener(
                'dragstart',
                function(event) {
                    if (!event.target.closest('.dn-draggable-table')) {
                        return;
                    }

                    window.DigitalNature.utils.dragTable.start(event);
                }
            );

            document.addEventListener(
                'dragover',
                function(event) {
                    if (!event.target.closest('.dn-draggable-table')) {
                        return;
                    }

                    window.DigitalNature.utils.dragTable.dragover(event);
                }
            );
        },
        start: function (event) {
            window.DigitalNature.utils.dragTable.row = event.target;
        },
        dragover: function (event) {
            event.preventDefault();

            let children= Array.from(event.target.parentNode.parentNode.children);

            if (children.indexOf(event.target.parentNode) > children.indexOf(window.DigitalNature.utils.dragTable.row)) {
                event.target.parentNode.after(window.DigitalNature.utils.dragTable.row);
            } else {
                event.target.parentNode.before(window.DigitalNature.utils.dragTable.row);
            }
        }
    },

    // utilities for use on forms
    forms: {
        hasErrorMessage: function(field) {
            const existingErrorMessage = field.parentElement.querySelector('.dn-form-error-message')

            return !!existingErrorMessage;
        },
        addErrorMessage: function(message, field, removeAfterSeconds = null, removeExistingErrors = true) {
            if (!field) {
                console.error('Cannot add error message, field does not exist. Message was:', message);
                return;
            }

            // create new error message container
            const errorMessage = document.createElement('div')
            errorMessage.style.width = '100%'
            errorMessage.classList.add('dn-form-error-message')
            errorMessage.textContent = message;

            if (removeExistingErrors) {
                // remove existing error messages
                window.DigitalNature.utils.forms.removeErrorMessage(field);
            }

            // add the new error message to the page
            field.parentElement.appendChild(errorMessage);

            if (removeAfterSeconds && removeExistingErrors) {
                setTimeout(
                    function() {
                        window.DigitalNature.utils.forms.removeErrorMessage(field)
                    },
                    removeAfterSeconds * 1000
                );
            }
        },

        removeErrorMessage: function(field) {
            // remove existing error messages
            const existingErrorMessage = field.parentElement.querySelector('.dn-form-error-message')
            if (existingErrorMessage) {
                existingErrorMessage.remove()
            }
        },

        removeAllErrorMessages: function(container) {
            container.querySelectorAll('.dn-utilities-error-message').forEach(function (error) {
                error.remove();
            });
        },

        updateFieldAndTriggerChangeEvent: function(input, newValue) {
            input.value = newValue;

            // create and dispatch an event so the field is updated in checkout
            let event = new Event('change');
            input.dispatchEvent(event);
        },
    },

    visibilityToggle: {
        init: function() {
            document.addEventListener(
                'click',
                function(event) {
                    if (!event.target.matches('.dn-toggle-visibility-trigger')) {
                        return;
                    }

                    event.preventDefault();

                    let targetId = event.target.dataset.targetId;

                    if (!targetId) {
                        // nothing to target
                        return false;
                    }

                    let targetElement = document.getElementById(targetId);

                    targetElement.classList.toggle('visible');

                    let togglerText = null;

                    if (targetElement.classList.contains('visible')) {
                        togglerText = event.target.dataset.closedText;
                    } else {
                        togglerText = event.target.dataset.openText;
                    }

                    event.target.textContent = togglerText;

                    return false;
                }
            );
        }
    },

    areYouSure: {
        init: function() {
            document.addEventListener(
                'click',
                function(event) {
                    if (!event.target.matches('.are-you-sure')) {
                        return;
                    }

                    let confirmationMessage = 'Are you sure? This cannot be undone';

                    if (event.target.dataset.confirmationMessage) {
                        confirmationMessage = event.target.dataset.confirmationMessage;
                    }

                    if (confirm(confirmationMessage)) {
                        return true;
                    } else {
                        event.preventDefault();
                        return false;
                    }
                }
            );
        }
    },


    // animated components
    animations: {
        addLoadingSpinner: function(container) {
            // remove existing loaders
            window.DigitalNature.utils.animations.removeLoadingSpinner(container);

            const loadingSpinner = document.createElement('div')
            loadingSpinner.classList.add('digital-nature-loader')
            const loadingSpinnerBackground = document.createElement('div')
            loadingSpinnerBackground.classList.add('digital-nature-loader-background');
            loadingSpinner.appendChild(loadingSpinnerBackground);
            const loadingSpinnerContent = document.createElement('div')
            loadingSpinnerContent.classList.add('digital-nature-loader-content');
            loadingSpinner.appendChild(loadingSpinnerContent);

            // add the new loader to the container
            container.appendChild(loadingSpinner);
        },

        removeLoadingSpinner: function(container) {
            const existingLoadingSpinner = container.querySelector('.digital-nature-loader')
            if (existingLoadingSpinner) {
                existingLoadingSpinner.remove()
            }
        }
    },
}

window.DigitalNature.utils.dragTable.init();
window.DigitalNature.utils.visibilityToggle.init();
window.DigitalNature.utils.areYouSure.init();