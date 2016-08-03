# accessible-captcha

A fully documented, easy to use PHP class to create multilingual accessible captchas for web applications.

## The need for an accessible captcha

The biggest part of current popular captcha solutions is based on the visual recognition of numbers, animals or other things in images. The accessibility handicap for such a solution is, that blind or visually impaired people can not solve it. The screenreader can't extract information from an image. These people are excluded from the content protected by the captcha.

## On the state of accessible captchas

Most of the time, accessible captcha solutions create a math challenge. e.g. *4 + 6*. Of course, this is easy for machines to parse. Better solutions use combinations between numbers and strings, e.g. *four plus 5*.  But this can also be easily parsed, because we know the range of used numbers (mostly between 0 and 20) and the 4 operators (+, -, \*, /), so we can make a mapping (plus => +), (minus => -) and so on.

## What makes this accessible captcha solution so special?

With this class you are able to create challenges with a dynamic syntax. For example, a challenge could be one of the following sentences:

	John has 18 gummy bears. He splits them among his 3 friends. How many gummy bears has every friend?
    Max has $17. How much money does he still have, if Anna takes away $5?
	The character sequence aaakoukfasdjk contains how many k's?
	Anna is 25  years old. She wants a friend with the smallest age difference. The ages of her potential friends are 65, 23, 96, 30. Which one does Anna choose?

As you can see, the machine has to analyze the semantics of the string to understand the challenge.

## How is the project designed?

+ It is very easy to use. In general, only two function calls are needed: get the captcha and validate it.
+ It is customizable. You can add or change as many different sentences as you want, for every challenge type.
+ It supports multiple languages. Sentences can be easily translated into other languages. (The two languages currently supported are Englisch and German)
+ It is portable. The library has a small footprint and can be embedded in different frameworks.
+ It is easy to extend. New challenge types can be defined, other sentences for available types can be added. Check the wiki for more information.

## Next steps

Clone or fork the accessible captcha, test it, and work with us to build the best accessible captcha ever. Testing it is very easy: in the main directory is a subdirectory *examples*. You only need to call examples/english.php to test the captcha in english or examples/german.php for the german captcha.

## How can you help

You can help to improve the accessible captcha by

+ programming new challenge types
+ translate existing challenges
+ write new, syntactically different sentences for existing challenges, e. g. *If a family has 5 members and they plan to get 3 children in the nex 5 years, how many members has the family then?*
+ test it and report bugs
+ make suggestions for new challenge types
+ tell every webmaster about the accessible captcha

## Thank you

Lets make the world more accessible for everybody. This captcha solution is a help not only for blind people, but also for everybody hating captchas which are difficult to solve and use ugly images with unreadable strings.

The goal wasn't to design a solution that no machine can ever solve (no captcha solution can do this), the goal was to provide a solution that is good enough to prevent the most bots spamming your site. Look, either you design a visual challenge so hard that no machine and no human can solve it, or you try your best to get a challenge thats difficult enough for machines and still easy for people to use.

Look in the wiki for the documentation, usage examples, infos on how create other sentences, infos on how to translate existing challenges and more.

Thank you!