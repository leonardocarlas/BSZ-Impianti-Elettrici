const itemTemplate = document.createElement('template');

class Item extends HTMLElement {

    title = this.getAttribute('title');
    template = `
        <style>
            p {
                color: blue;
            }
        </style>
        <div>
            <p>${this.title}</p>
        </div>
        `;

    constructor() {
        super();
    }

    connectedCallback() {
        console.log("connectedCallback");
        console.log(this.template, this.title);
        this.render();
        const shadowRoot = this.attachShadow({ mode: 'open' });
        shadowRoot.appendChild(itemTemplate.content);
    }

    render() {
        console.log("Re-rendering");
        itemTemplate.innerHTML = this.template;
    }
}

customElements.define('item-component', Item);

        
