import React from "react";

function SiteFooter() {
  let userProfile = adminUrl + "profile.php";

  return (
    <footer className="site-footer flex-box space-around bg-black space">
      <p>
        <a href={userProfile}>Manage your account</a>
      </p>
      <p>
        <a href={homeUrl}>Back to main site</a>
      </p>
    </footer>
  );
}

export default SiteFooter;
