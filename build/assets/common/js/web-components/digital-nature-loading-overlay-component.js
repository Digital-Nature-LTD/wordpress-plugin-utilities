import DigitalNatureWebComponent from "@digital-nature-ltd/web-component";

class DigitalNatureLoadingOverlayComponent extends DigitalNatureWebComponent
{
    messages = [];
    messagePosition = 'lower';
    currentMessage = null;
    messageClass = 'dn-loading-overlay__message'
    cycleSpeed = 5000;
    cycleMessagesInterval = null;

    constructor() {
        super('digital-nature-loading-overlay-template');

        // add the messages and position to the component properties
        let messagesPassedIn = this.dataset.messages ? JSON.parse(this.dataset.messages): [];
        this.messagePosition = this.dataset.messagePosition ? this.dataset.messagePosition : 'lower';
        this.cycleSpeed = this.dataset.cycleSpeed ? this.dataset.cycleSpeed : 5000;

        // don't configure if there are no messages
        if (messagesPassedIn.length === 0) {
            return;
        }

        let component = this;

        // add all the messages, this will trigger the interval
        messagesPassedIn.forEach(message => {
            component.addMessage(message);
        })
    }

    startInterval()
    {
        let component = this;

        // add the initial message
        this.displayNextMessage();

        this.cycleMessagesInterval = setInterval(function () {
            component.displayNextMessage();
        }, this.cycleSpeed)
    }

    getNextMessage()
    {
        const currentIndex = this.messages.indexOf(this.currentMessage);
        const nextIndex = (currentIndex + 1) % this.messages.length;

        return this.messages[nextIndex];
    }

    clearMessage()
    {
        let message = this.querySelector(`.${this.messageClass}`);

        if (message) {
            message.remove();
        }
    }

    displayNextMessage()
    {
        // set the current message to the next one
        this.currentMessage = this.getNextMessage();

        // clear what we already have
        this.clearMessage()

        // build the new message
        let currentMessage = document.createElement('div');
        currentMessage.classList.add(this.messageClass);
        currentMessage.slot = this.messagePosition === 'upper' ? 'upper-text' : 'lower-text';
        currentMessage.textContent = this.currentMessage;
        this.appendChild(currentMessage);
    }

    deleteMessage(messageText)
    {
        const messageIndex = this.messages.indexOf(messageText);
        this.messages.splice(messageIndex, 1);

        if (this.messages.length === 0) {
            this.classList.remove('populated');
            // clear the interval
            clearInterval(this.cycleMessagesInterval);
            // remove this element
            this.remove();
        }
    }

    addMessage(messageText)
    {
        this.classList.add('populated');

        const messageIndex = this.messages.indexOf(messageText);

        if (messageIndex !== -1) {
            // the message already exists
            return;
        }

        this.messages.push(messageText);

        if (!this.cycleMessagesInterval) {
            this.startInterval();
        }
    }

}

// add the custom element to the registry
customElements.define('digital-nature-loading-overlay', DigitalNatureLoadingOverlayComponent);