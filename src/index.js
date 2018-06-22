import React from 'react'
import ReactDOM from 'react-dom'

// we need to get some stuff from the DOM
let user = document.querySelector('#root').dataset.user;
let api_root = document.querySelector( 'link[rel="https://api.w.org/"]' ).getAttribute('href');

class Index extends React.Component {

   // _membership = false


    render() {
        return <h1>Psychedelic Dracula</h1>
    }

    componentDidMount() {
        fetch( api_root + 'wp/v2/users/' + user )
        .then(function(response) {
            return response.json();
        })
        .then(function(asJson) {
            console.log( asJson._membership );
        });
    }

}


ReactDOM.render( <Index />, document.getElementById('root') );