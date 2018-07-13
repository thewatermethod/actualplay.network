import React from "react";

function SiteHeader() {
  const headerStyles = {
    justifyContent: "center",
    maxHeight: "100px"
  };

  const imageStyles = {
    height: "100px"
  };

  return (
    <header className="site-header flex-box" style={headerStyles}>
      <a className="header-logo" href="" rel="home">
        <img
          src="http://apn.local/wp-content/uploads/2018/06/apn2.svg"
          style={imageStyles}
        />
      </a>
    </header>
  );
}

export default SiteHeader;
