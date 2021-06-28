ALTER TABLE `posts`
CHANGE `category` `category_id` INTEGER NOT NULL;

ALTER TABLE `categories`
MODIFY `name` VARCHAR(150) UNIQUE NOT NULL;