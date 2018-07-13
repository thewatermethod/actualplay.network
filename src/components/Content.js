import React from "react";
import ReactHtmlParser from "react-html-parser";

class Content extends React.Component {
  constructor(props) {
    super(props);
  }

  render() {
    const posts = this.props.posts;
    const renderedPosts = posts.map(post => (
      <article key={post.id} className="card">
        <h2>{post.title.rendered}</h2>
        <div>{ReactHtmlParser(post.content.rendered)}</div>
      </article>
    ));

    return <div>{renderedPosts}</div>;
  }
}

export default Content;
