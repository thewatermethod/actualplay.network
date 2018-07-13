import React from "react";
import ReactDOM from "react-dom";

import MemberContent from "./components/MemberContent";
import NotSubscribed from "./components/NotSubscribed";
import SiteHeader from "./components/SiteHeader";
import SiteFooter from "./components/SiteFooter";

class Index extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      user: "0"
    };
  }

  updateUser = user => {
    this.setState({
      user: user
    });
  };

  render() {
    if (this.state.user == "0") {
      return (
        <div>
          <SiteHeader />
          <NotSubscribed
            user={this.state.user}
            updateUser={this.updateUser}
            membership={false}
          />
        </div>
      );
    } else {
      return (
        <div>
          <SiteHeader />
          <MemberContent user={this.state.user} />
          <SiteFooter />
        </div>
      );
    }
  }

  componentDidMount() {
    const user = document.querySelector("#root").dataset.user;
    this.setState({
      user: user
    });
  }
}

ReactDOM.render(<Index />, document.getElementById("root"));
