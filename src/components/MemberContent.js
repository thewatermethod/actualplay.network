import React from "react";
import Content from "./content";
import LoadMore from "./LoadMore";

export default class MemberContent extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      content: [],
      offset: 0,
      morePosts: false
    };
  }

  addToContent(response) {
    var morePosts = true;

    if (response.length < 10) {
      morePosts = false;
    }

    this.setState({
      content: this.state.content.concat(response),
      offset: this.state.offset + 3,
      morePosts: morePosts
    });
  }

  render() {
    return (
      <div className="inner">
        <h1 className="page-title">Members Only Content</h1>
        <Content posts={this.state.content} />
        {this.state.morePosts && <LoadMore />}
      </div>
    );
  }

  componentDidMount() {
    let api_root = document
      .querySelector('link[rel="https://api.w.org/"]')
      .getAttribute("href");

    fetch(
      api_root + "wp/v2/members_only?per_page=3&offset=" + this.state.offset
    )
      .then(response => response.json())
      .then(
        response => {
          this.addToContent(response);
        },
        error => {
          console.error(error);
        }
      );
  }
}
