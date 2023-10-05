const itemTemplate = document.createElement('template');

class Item extends HTMLElement {

    title = this.getAttribute('title');
    imageLink = this.getAttribute('imageLink');
    ebayLink = this.getAttribute('ebayLink');
    template = `
    <style>

        .card {
            max-width: 10%;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background-color: #fff;
            text-align: center;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
            transform: scale(1.05);
            cursor: pointer; 
        }

        .card img {
            max-width: 100%;
            height: auto;
        }

        .card p {
            color: blue;
            font-weight: bold;
        }

        .card a button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            padding: 5px 10px;
            cursor: pointer;
            text-decoration: none;
        }

        .card a button:hover {
            background-color: #0056b3;
        }
    </style>

    <div class="card">
        <img src="${this.imageLink}" alt="${this.title}">
        <p>${this.title}</p>
        <a href="${this.ebayLink}" target="_blank">
            <button>Vai all'articolo</button>
        </a>
    </div>
        `;

    constructor() {
        super();
    }

    connectedCallback() {
        this.render();
        const shadowRoot = this.attachShadow({ mode: 'open' });
        shadowRoot.appendChild(itemTemplate.content);
    }

    render() {
        itemTemplate.innerHTML = this.template;
    }
}

customElements.define('item-component', Item);

        
