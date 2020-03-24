import React from 'react';
import ReactDOM from 'react-dom';
import Cookies from 'js-cookie';

export default class Example extends React.Component
{
    constructor(){

        super();
        this.state = {
            products : []
        };
    }

    componentDidMount(){
        try {
            const response = fetch('/invoices/products');
            console.log(response.data);
        } catch (err) {
            // this.setState({ isLoading: false });
            // console.error(err);
        }
    }
   render(){
    return (
        <div>

        </div>
    );
   }
}


if (document.getElementById('selectProduct')) {
    ReactDOM.render(<Example />, document.getElementById('selectProduct'));
}
