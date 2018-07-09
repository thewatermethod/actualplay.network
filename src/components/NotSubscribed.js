import React from 'react'


export default class NotSubscribed extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {

        if (this.props.membership == true) {
            return <div></div>
        }

        return (
            <div>
                <h2>You Aren't Subscribed Yet?</h2>
                <p>If you'd like to and get access to all the bonus content, enter your email address below.</p>
                <form>
                    <fieldset>
                        <label htmlFor="email">Email</label>
                        <input type="email" />
                    </fieldset>
                    <input type="submit" value="Become a Member" />                    
                </form>
            </div>
        )
    }
}
