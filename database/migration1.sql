UPDATE `posts` SET `category`=1;

ALTER TABLE `posts` 
MODIFY `category` INTEGER NOT NULL,
ADD CONSTRAINT `post_category_fk` FOREIGN KEY (`category`) REFERENCES `categories`(`id`);

ALTER TABLE `posts`
CHANGE `category` `category_id`;

ALTER TABLE `categories`
MODIFY `name` VARCHAR(150) UNIQUE NOT NULL;