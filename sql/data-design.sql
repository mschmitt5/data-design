ALTER DATABASE mschmitt5 CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS clap;
DROP TABLE IF EXISTS article;
DROP TABLE IF EXISTS profile;

CREATE TABLE profile (
  profileId BINARY(16) NOT NULL,
  profileEmail VARCHAR(128) NOT NULL,
  profileHash CHAR(128) NOT NULL,
  profileName VARCHAR(32) NOT NULL,
  profileSalt CHAR(64) NOT NULL,
  profileStatement VARCHAR(128),
  UNIQUE(profileEmail),
  PRIMARY KEY(profileId)
);

CREATE TABLE article (
  articleId BINARY(16) NOT NULL,
  articleProfileId BINARY(16) NOT NULL,
  articleText VARCHAR(65535) NOT NULL,
  articleTitle VARCHAR(128) NOT NULL,
  INDEX (articleProfileId),
  FOREIGN KEY(articleProfileId) REFERENCES profile(profileId),
  PRIMARY KEY(articleId)
);

CREATE TABLE clap(
  clapId BINARY(16) NOT NULL,
  clapArticleId BINARY(16) NOT NULL,
  clapProfileId BINARY(16) NOT NULL,
  INDEX(clapArticleId),
  INDEX(clapProfileId),
  FOREIGN KEY(clapArticleId) REFERENCES article(articleId),
  FOREIGN KEY(clapProfileId) REFERENCES profile(profileId),
  PRIMARY KEY(clapId)
);