import React from "react";

class NotSubscribed extends React.Component {
  constructor(props) {
    super(props);
    this.emailInput = React.createRef();
    this.nonce = React.createRef();
  }

  subscribeTo = event => {
    event.preventDefault();

    if (this.emailInput.current.value == "") {
      return;
    }

    if (this.nonce.current.value != "nonce") {
      return;
    }

    const nonce = document.querySelector("#membership-nonce").value;
    const referer = document.querySelector('input[name="_wp_http_referer"]')
      .value;

    const ajaxUrl =
      adminUrl +
      "admin-ajax.php?action=create_user&email=" +
      this.emailInput.current.value +
      "&nonce=" +
      nonce +
      "&referer=" +
      referer;

    fetch(ajaxUrl, {
      mode: "cors",
      method: "POST"
    })
      .then(res => res.json())
      .catch(error => console.error(error))
      .then(response => this.props.updateUser("1"));
  };

  render() {
    let redirect = encodeURIComponent(window.location.href);
    let login =
      window.location.origin + "/wp-login.php?redirect_to=" + redirect;

    if (this.props.membership == true) {
      return <div />;
    }

    return (
      <div className="inner">
        <div className="card">
          <h2>You Aren't Subscribed Yet?</h2>
          <p>
            If you'd like to (and get access to all the bonus content), enter
            your email address below.
          </p>
          <form onSubmit={this.subscribeTo}>
            <fieldset className="no-border">
              <label htmlFor="email">Email</label>
              <input type="email" ref={this.emailInput} />
            </fieldset>
            <fieldset className="no-border">
              <input className="button" type="submit" value="Become a Member" />
              <a className="button" href={login}>
                Login
              </a>
            </fieldset>
            <input type="hidden" name="nonce" value="nonce" ref={this.nonce} />
          </form>
        </div>
      </div>
    );
  }
}

export default NotSubscribed;
