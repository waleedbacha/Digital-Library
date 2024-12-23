-- PostgreSQL SQL Dump

-- Database: emanon

-- --------------------------------------------------------

-- Table structure for table "books"
CREATE TABLE books (
  book_id SERIAL PRIMARY KEY,
  isbn VARCHAR(17) NOT NULL,
  book_title VARCHAR(200) DEFAULT NULL,
  category VARCHAR(50) DEFAULT NULL,
  sub_category VARCHAR(50) DEFAULT NULL,
  author VARCHAR(50) DEFAULT NULL,
  publisher VARCHAR(50) DEFAULT NULL,
  edition VARCHAR(10) DEFAULT NULL,
  volume VARCHAR(10) DEFAULT NULL,
  year VARCHAR(10) DEFAULT NULL,
  cover VARCHAR(200) DEFAULT NULL,
  file VARCHAR(200) DEFAULT NULL,
  description TEXT DEFAULT NULL
);

-- Dumping data for table "books"
INSERT INTO books (book_id, isbn, book_title, category, sub_category, author, publisher, edition, volume, year, cover, file, description) VALUES
(72, 34567890, 'Sample Book ', 'communications', NULL, 'Peter', 'Newyork times', '1', '1', '1994', 'cover_1725074707805_kyw7s30ow.jpg', 'Steal Like an Artist ( PDFDrive ).pdf', '\"Steal Like an Artist\" by Austin Kleon is a manifesto for creativity in the digital age. It offers ten transformative principles to help readers unlock their artistic potential by embracing the idea that nothing is original and that creativity is about remixing and reinterpreting existing ideas.\r\n With a focus on practical advice, Kleon encourages readers to draw inspiration from their influences, embrace their imperfections, and cultivate their creativity in a world of constant change. This book is a must-read for anyone looking to harness their creative power and make art in a way that feels authentic and meaningful.'),
(73, 2147483647, 'Chemistry Notes', 'Art', NULL, 'Ali', 'Book publisher', '1', '', '', 'cover_1725732902302_xqcio0zia.jpg', 'Chemistry 9th Notes ch 2.pdf', ''),
(74, 2147483647, 'Artificial intelligence', 'Art', NULL, 'Peter', 'Lahore publications', '1', '23424', '', 'cover_1725732960293_v7qavggzj.jpg', 'مصنوعی ذہانت.pdf', ''),
(75, 2147483647, 'Steel Like an artist', 'Art', NULL, 'Peter', '', '1', '1', '2003', 'cover_1725732990208_gth48n0ca.jpg', 'Steal Like an Artist ( PDFDrive ).pdf', ''),
(76, 2147483647, 'another in art category ', 'Art', NULL, '234', 'sa', '1', '', '', '', 'دجال_3_جلدیں_ایک_ساتھ_مکمل_از_مفتی_ابو_لبابہ_شاہ_منصور.pdf', ''),
(77, 2147483647, 'test book', 'Art', NULL, '', '', '', '', '', 'cover_1725733302699_zvkd919da.jpg', 'دجال_3_جلدیں_ایک_ساتھ_مکمل_از_مفتی_ابو_لبابہ_شاہ_منصور.pdf', ''),
(78, 2147483647, 'same isbn test - changed ', 'Art', NULL, '', '', '', '', '', 'cover_1725733671183_u7w95c3dh.jpg', 'zaslow_physmatics.pdf', '');

-- --------------------------------------------------------

-- Table structure for table "categories"
CREATE TABLE categories (
  cat_id SERIAL PRIMARY KEY,
  cat_name VARCHAR(50) DEFAULT NULL
);

-- Dumping data for table "categories"
INSERT INTO categories (cat_id, cat_name) VALUES
(14, 'Science'),
(23, 'Art'),
(24, 'accounting'),
(25, 'business administration'),
(26, 'communications'),
(27, 'Manufacturing technologies'),
(28, 'Economics'),
(29, 'english studies'),
(30, 'Global studies'),
(31, 'Environmental studies'),
(32, 'Graphic and interective design'),
(33, 'History'),
(34, 'Mathematics'),
(35, 'Music');

-- --------------------------------------------------------

-- Table structure for table "users"
CREATE TABLE users (
  user_id SERIAL PRIMARY KEY,
  name VARCHAR(20) DEFAULT NULL,
  phone VARCHAR(15) DEFAULT NULL,
  username VARCHAR(8) NOT NULL,
  password VARCHAR(50) NOT NULL,
  role VARCHAR(10) DEFAULT NULL
);

-- Dumping data for table "users"
INSERT INTO users (user_id, name, phone, username, password, role) VALUES
(10, 'admin', '123456789', 'user', 'admin', NULL);

CREATE TABLE signup_users (
    id SERIAL PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password TEXT NOT NULL
);


-- Dumping data for table "users"
INSERT INTO signup_users (id, fullname,email,username, password) VALUES
(1, 'waleed', 'abc@gmail.com', 'abc', '123');


-- --------------------------------------------------------

-- Indexes for dumped tables

-- Indexes for table "books"
-- No need to define PRIMARY KEY since it's already set by SERIAL.

-- Indexes for table "categories"
-- No need to define PRIMARY KEY since it's already set by SERIAL.

-- Indexes for table "users"
-- No need to define PRIMARY KEY since it's already set by SERIAL.
