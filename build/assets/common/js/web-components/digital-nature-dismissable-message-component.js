import DigitalNatureWebComponent from "@digital-nature-ltd/web-component";

class DigitalNatureDismissableMessageComponent extends DigitalNatureWebComponent
{
    CLASS_ERROR = 'error';
    CLASS_WARNING = 'warning';
    CLASS_SUCCESS = 'success';
    CLASS_INFO = 'info';

    constructor() {
        super('digital-nature-dismissable-message-template');
    }

    setContent(messageText, statusClass)
    {
        this.setSlotTextContent('message', messageText);
        this.classList.remove(this.CLASS_ERROR, this.CLASS_WARNING, this.CLASS_INFO, this.CLASS_SUCCESS);
        this.classList.add(statusClass);
    }
}

// add the custom element to the registry
customElements.define('digital-nature-dismissable-message', DigitalNatureDismissableMessageComponent);