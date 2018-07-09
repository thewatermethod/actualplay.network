import React from 'react'
import NotSubscribed from './NotSubscribed'

export default class MemberContent extends React.Component {

    constructor(props) {
        super(props);
    }
 

    render() {
        return (
            <div>
                <h2>Member Content</h2>                
            </div>
        )
    }

    componentDidMount() {

        let api_root = document.querySelector( 'link[rel="https://api.w.org/"]' ).getAttribute('href')

        fetch( api_root + 'wp/v2/users/' + this.props.userId )
        .then(function(response) {
            return response.json();
        })
        .then(function(asJson) {
            console.log( asJson._membership );
        });

    }

}
