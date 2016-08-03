# accessible-captcha

A fully commented, easy to use  class for creating multilingual accessible captchas written in PHP.

##Why we need a accessible captcha

The most captcha solutions based on visual recognition of numbers, animals or other  things embeded in a Image. The problem of this kind of solution is, blind or visually impaired people can't solve this captchas, because the screenreader (software which translatet Text to speech)  can't read the image content.

##Which accessible captcha solutions are available

The most kind of accessible captcha solutions create a math-challenge. So like 4 + 6. Of course this is easy for Robots to parse. Better solutions use randomly string number combination like four plus 5.  But this can be easy parsed to, because we know the range of used numbers (mostly between 0 and 20) and the 4 operators (+, -, \*, /), so we can make mapping (plus => +), (minus => -) and so on.

##What makes this accessible captcha solution special?

With this class you able to create challenges that works with semantic challenges. One example challenge could be  'John has 18 gummy bears. He splits them among his 3 friends. How many gummy bears has every friend?'.

Or 'Max has $17. How much money does he still have, if Anna takes away $5?'.

or 'The character sequence aaakoukfasdjk contains how many k's?'

Or 'Anna is 25  years old. She wants a friend with the smallest age difference. The ages of her potential friends are 65, 23, 96, 30. Which one does Anna choose?'

As you see, the robot must analyce the semantic of the string to know, what the challenge ist.

##How the project is designed?

+ Usage: Very easy to use. (It only needs 2 func-calls to handle the captcha-generation, showing, and check the users input.)
+ customizable: You can add as many as semantic descriptions for every challenge type as you want.
+ Multilingual: Easy to translate in other languages (current status: german and english)
+ easy portable: It can easy be ported to any framework.
+ Extendable: Easy to write new challengetypes. Look in the wiki for this.

##The next step

Fork the accessible captcha, test it, and work with us to build the best accessible captcha ever. Testing ist very easy, in the main directory is a subdirectory examples. You only need to call localhost/pathToAccessibleCaptcha/examples/english.php to test the Captcha in english or localhost/pathToAccessibleCaptcha/examples/german.php for german. 

##How can I help

You can help to improve the accessible captcha by

+ programming new challenge-types.
+ translate the existing challenges.
+ Write new semantic description for existing challenges e. g. If a family has 5 members and they plan to get 3 children in the nex 5 years, how many members has the family then?
+ test and report bugs.
+ make suggestion for new challenge types.
+ tell every webmaster about accessible captcha.

##Thank you

Lets make the world more accessible for everybody. This captcha solution helps not only blind people, it helps everybody who hates solve unsolvable, ugly images with unreadable strings. The goal wasn't to design a solution that no robot can ever solve (no captcha solution can provide this), the goal was a solution that it's good enough to prevent the most bots spaming your site.

Look, either you design a so hard visual challenge that no robot and no human can solve it, or you try your best to get a challenge thats hard enought for robots, and easy for people. I'm always design sites for good user experince, not only to prevent robots to use my service.

Look in the Wiki for a documentation, usage examples, how create semantic description, how to translate existing challenges and more.

Thank you!