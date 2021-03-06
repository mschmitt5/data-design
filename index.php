<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Design</title>
    <link rel="stylesheet" href="./CSS/style.css">
</head>
<body>
    <div class="center">
    <h1>Data Design</h1>
    <h2>Persona - Tiberius Calabrese</h2>
    <p class="center">Tiberius Calabrese is an airline pilot who loves to keep his mind occupied with by learning the basics of new things. He is a fairly experienced user and will be using a Samsung Galaxy S8. He has turned to Medium in order to read blog posts on his phone instead of bringing books with him on his flights. He's become particularly interested in medical science and human nature but has no interest in writing a blog himself.</p>
    <img src="images/tiberius.jpg" alt="Tiberius Calabrese">
    <h2>User Story</h2>
    <p>Casual user, Tiberius, wants to find more articles on medicine and humanity. He would also like to find authors whose writing he enjoys.</p>
    <h2>Use Case and Interaction Flow</h2>
    <ol class="center-list">
        <li>Tiberius types "medicine" and "humanity" into the search bar on Medium.</li>
        <li>The site brings up articles including the tags "medicine" and "humanity".</li>
        <li>Tiberius recognizes the article he read in the past and clicks on it.</li>
        <li>The site takes him to this specific article.</li>
        <li>Tiberius decides to clap a few times in order to show his appreciation.</li>
        <li>The site registers these claps and adds them to the total number of claps on the article.</li>
        <li>Tiberius would like to follow this author so that he doesn't miss any of his articles.</li>
        <li>He clicks on the "follow" button.</li>
        <li>The site prompts him to sign in or create an account.</li>
        <li>He enters in his relevant info in order to create an account(email, username, etc).</li>
        <li>The site checks that this information is valid and available and creates Tiberius' account.</li>
        <li>Tiberius clicks the "follow" button again and successfully follows Dr. McCoy.</li>
    </ol>
    <img src="images/inkedmedium1.jpg" alt="" width="500">
    <img src="images/inkedmedium2.jpg" alt="" width="500">
    </div>
        <h2>Entities and Attributes</h2>
        <ul>
            <li>Profile
                <ul>
                    <li>profileId (primary key)</li>
                    <li>profileName</li>
                    <li>profileStatement</li>
                    <li>profileEmail</li>
                    <li>profileHash</li>
                    <li>profileSalt</li>
                </ul>
            </li>
            <li>Article
                <ul>
                    <li>articleId (primary key)</li>
                    <li>articleProfileId (foreign key)</li>
                    <li>articleText</li>
                    <li>articlePhoto</li>
                    <li>articleTitle</li>
                </ul>
            </li>
            <li>Clap (weak, try hard)
                <ul>
                    <li>clapId (primary key)</li>
                    <li>clapProfileId (foreign key)</li>
                    <li>clapArticleId (foreign key)</li>
                </ul>
            </li>
        </ul>
        <h2>Relationships</h2>
        <ul>
            <li>Profile to Article 1-to-n</li>
            <li>Claps to Article m-to-n</li>
            <li>Profile to Claps m-to-n</li>
        </ul>
    <div>
        <h2>Entity Relationship Diagram</h2>
        <img src="images/erd.jpg">
    </div>
    <a rel="index" href="female-lead.html">Female Lead</a>
</body>
</html>