import React from 'react'
import ReactDOM from 'react-dom'

import MemberContent from './components/MemberContent'
import NotSubscribed from './components/NotSubscribed'

// we need to get some stuff from the DOM
let user = document.querySelector('#root').dataset.user

class Index extends React.Component {

    state = {
        membership: '',
        subscription: '',
    };

    render() {
        if( user == '0' ){
           return <NotSubscribed membership={false} />
        }
        return <MemberContent userId={user} />
    }


}

ReactDOM.render( <Index />, document.getElementById('root') );