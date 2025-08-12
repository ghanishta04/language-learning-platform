-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2025 at 08:05 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `langlearn`
--

-- --------------------------------------------------------

--
-- Table structure for table `completed_lessons`
--

CREATE TABLE `completed_lessons` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `lesson_title` varchar(255) DEFAULT NULL,
  `status` enum('completed','incomplete') DEFAULT 'completed',
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `lesson_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `completed_lessons`
--

INSERT INTO `completed_lessons` (`id`, `user_id`, `lesson_title`, `status`, `completed_at`, `lesson_id`) VALUES
(1, 2, 'അക്ഷരമാല പഠിക്കുക (Learn the Alphabet)', 'completed', '2025-07-20 16:06:06', 0),
(2, 2, 'എണ്ണങ്ങളും എണ്ണല്‍ (Numbers and Counting)', 'completed', '2025-07-21 12:45:32', 0),
(3, 2, 'ഗ്രാമർ അടിസ്ഥാനങ്ങൾ (Basic Grammar Rules)', 'completed', '2025-07-21 13:38:24', 0),
(4, 2, 'എണ്ണങ്ങളും എണ്ണല്‍ (Numbers and Counting)', 'completed', '2025-07-21 13:38:30', 0),
(5, 2, 'ആശംസകളും പരിചയങ്ങളും (Greetings and Introductions)', 'completed', '2025-07-21 13:38:45', 0),
(6, 2, 'ആശംസകളും പരിചയങ്ങളും (Greetings and Introductions)', 'completed', '2025-07-21 14:22:05', 0),
(7, 2, 'અક્ષરમાળા શીખો (Learn the Alphabet)', 'completed', '2025-07-24 16:10:25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `lessons` int(11) NOT NULL,
  `level` enum('beginner','intermediate','advanced') NOT NULL,
  `completion` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `level` enum('beginner','intermediate','advanced') DEFAULT 'beginner'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `course_name`, `title`, `level`) VALUES
(1, 'english', 'Learn the Alphabet', 'beginner'),
(2, 'english', 'Greetings and Introductions', 'beginner'),
(3, 'english', 'Numbers and Counting', 'beginner'),
(4, 'english', 'Basic Grammar Rules', 'beginner'),
(5, 'english', 'Days and Months', 'beginner'),
(10, 'english', 'TEST', 'beginner'),
(11, 'Hindi', 'अक्षर सीखें (Learn the Alphabet)', 'beginner'),
(12, 'Hindi', 'नमस्ते और परिचय (Greetings and Introductions)', 'beginner'),
(13, 'Hindi', 'संख्याएँ और गिनती (Numbers and Counting)', 'beginner'),
(14, 'Hindi', 'मूल व्याकरण नियम (Basic Grammar Rules)', 'beginner'),
(19, 'Hindi', 'परिवार और दोस्त (Family & Friends Vocabulary)', 'beginner'),
(20, 'Hindi', 'सरल वार्तालाप (Practice Simple Dialogues)', 'beginner'),
(21, 'Malayalam', 'അക്ഷരമാല പഠിക്കുക (Learn the Alphabet)', 'beginner'),
(22, 'Malayalam', 'ആശംസകളും പരിചയങ്ങളും (Greetings and Introductions)', 'beginner'),
(23, 'Malayalam', 'എണ്ണങ്ങളും എണ്ണല്‍ (Numbers and Counting)', 'beginner'),
(24, 'Malayalam', 'ഗ്രാമർ അടിസ്ഥാനങ്ങൾ (Basic Grammar Rules)', 'beginner'),
(29, 'Malayalam', 'കുടുംബവും സുഹൃത്തുക്കളും (Family & Friends Vocabulary)', 'beginner'),
(30, 'Malayalam', 'എളുപ്പമായ സംഭാഷണങ്ങൾ (Practice Simple Dialogues)', 'beginner'),
(31, 'Gujarati', 'અક્ષરો શીખો (Learn the Alphabet)', 'beginner'),
(32, 'Gujarati', 'અભિવાદન અને પરિચય (Greetings and Introductions)', 'beginner'),
(33, 'Gujarati', 'આંકડા અને ગણતરી (Numbers and Counting)', 'beginner'),
(34, 'Gujarati', 'મૂળ વ્યાકરણ નિયમો (Basic Grammar Rules)', 'beginner'),
(35, 'Gujarati', 'દિવસો અને મહિના (Days and Months)', 'beginner'),
(36, 'Gujarati', 'કુટુંબ અને મિત્રો શબ્દભંડાર (Family & Friends Vocabulary)', 'beginner'),
(37, 'Gujarati', 'સરળ સંવાદ (Practice Simple Dialogues)', 'beginner'),
(45, 'Telugu', 'అక్షరాలను నేర్చుకోండి (Learn the Alphabet)', 'beginner'),
(46, 'Telugu', 'శుభాకాంక్షలు మరియు పరిచయం (Greetings and Introductions)', 'beginner'),
(47, 'Telugu', 'సంఖ్యలు మరియు లెక్కింపు (Numbers and Counting)', 'beginner'),
(48, 'Telugu', 'ప్రాథమిక వ్యాకరణ నియమాలు (Basic Grammar Rules)', 'beginner'),
(49, 'Telugu', 'రోజులు మరియు నెలలు (Days and Months)', 'beginner'),
(50, 'Telugu', 'కుటుంబం మరియు స్నేహితులు పదభాండం (Family & Friends Vocabulary)', 'beginner'),
(51, 'Telugu', 'సరళమైన సంభాషణలు (Practice Simple Dialogues)', 'beginner'),
(52, 'assamese', 'আখৰ শিকা (Learn the Alphabet)', 'beginner'),
(53, 'assamese', 'নমস্কাৰ আৰু পৰিচয় (Greetings and Introductions)', 'beginner'),
(54, 'assamese', 'সংখ্যা আৰু গণনা (Numbers and Counting)', 'beginner'),
(55, 'assamese', 'প্ৰাথমিক ব্যাকৰণ নিয়ম (Basic Grammar Rules)', 'beginner'),
(56, 'assamese', 'দিন আৰু মাহ (Days and Months)', 'beginner'),
(57, 'assamese', 'পৰিয়াল আৰু বন্ধুবৰ্গ শব্দভঁৰাল (Family & Friends Vocabulary)', 'beginner'),
(58, 'assamese', 'সহজ সংলাপ (Practice Simple Dialogues)', 'beginner');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_flashcards`
--

CREATE TABLE `lesson_flashcards` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `front_text` text NOT NULL,
  `front_hinglish` text NOT NULL,
  `back_text` text NOT NULL,
  `back_hinglish` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lesson_flashcards`
--

INSERT INTO `lesson_flashcards` (`id`, `lesson_id`, `front_text`, `front_hinglish`, `back_text`, `back_hinglish`) VALUES
(1, 2, 'Hello', '', 'hai-llo', 'ha-lo'),
(2, 2, 'What’s your name?', 'wats yor neym', 'My name is _____', 'mai neym iz _____'),
(3, 2, 'How are you?', 'hau aar yoo', 'I’m fine, thank you!', 'aim fain, thank yoo'),
(4, 2, 'Goodbye', 'gud-bai', 'See you later! / Bye!', 'see yoo lay-tar / bai'),
(5, 2, 'Where are you from?', 'vayr aar yoo frum', 'I’m from India.', 'aim frum in-dee-ya'),
(6, 3, 'One', 'wan', 'This is number one.', 'dhis iz num-bar wan'),
(7, 3, 'Two', 'too', 'I have two pens.', 'ai hav too penz'),
(8, 3, 'Three', 'three', 'He has three books.', 'hee haz three buks'),
(9, 3, 'Four', 'fohr', 'There are four apples.', 'dheyr aar fohr ae-pls'),
(10, 3, 'Five', 'faiv', 'Give me five minutes.', 'giv mee faiv mi-nits'),
(11, 5, 'What time is it?', 'wot taim iz it?', 'It is 5 o’clock.', 'it iz faiv o-klok'),
(12, 5, 'It’s 3 PM.', 'its three pee-em', 'I will come at 3.', 'ai vil kum at three'),
(13, 5, 'When do you sleep?', 'ven do yoo sleep?', 'I sleep at 10 PM.', 'ai sleep at ten pee-em'),
(14, 5, 'What day is today?', 'wot dey iz to-dey?', 'Today is Monday.', 'to-dey iz mun-dey'),
(15, 5, 'It’s 9:30 AM.', 'its nain thur-tee ey-em', 'I wake up at 9:30.', 'ai vayk ap at nain thur-tee'),
(16, 1, 'A for Apple', 'ey for ae-pl', 'ey for ae-pl', ''),
(17, 1, 'B for Ball', '', 'bee for bawl', ''),
(18, 1, 'C for Cat', '', 'see for kaet', ''),
(19, 1, 'D for Dog', '', 'dee for dawg', ''),
(20, 1, 'E for Elephant', '', 'ee for ele-faent', ''),
(21, 4, 'I am a student.', '', 'ai am a stoo-dent.', ''),
(22, 4, 'She is my friend.', '', 'shee iz mai frend.', ''),
(23, 4, 'They are playing.', '', 'dhey aar ple-ing.', ''),
(24, 4, 'He is a doctor.', '', 'hee iz a dawk-tar.', ''),
(25, 4, 'We are happy.', '', 'vee aar ha-pee.', ''),
(26, 11, 'अ', 'a', 'अनार', 'anaar'),
(27, 11, 'आ', 'aa', 'आम', 'aam'),
(28, 11, 'इ', 'i', 'इमली', 'imli'),
(29, 11, 'ई', 'ee', 'ईख', 'eekh'),
(30, 11, 'उ', 'u', 'उल्लू', 'ulloo'),
(31, 11, 'ऊ', 'oo', 'ऊंट', 'oont'),
(32, 11, 'ए', 'e', 'एड़ी', 'edi'),
(33, 11, 'ऐ', 'ai', 'ऐनक', 'ainak'),
(34, 11, 'ओ', 'o', 'ओखली', 'okhli'),
(35, 11, 'औ', 'au', 'औज़ार', 'auzaar'),
(36, 11, 'अं', 'an', 'अंगूर', 'angoor'),
(37, 11, 'अः', 'ah', 'दुःख', 'duhkh'),
(38, 11, 'क', 'ka', 'कमल', 'kamal'),
(39, 11, 'ख', 'kha', 'खरगोश', 'khargosh'),
(40, 11, 'ग', 'ga', 'गमला', 'gamla'),
(41, 11, 'घ', 'gha', 'घर', 'ghar'),
(42, 11, 'च', 'cha', 'चमचम', 'chamcham'),
(43, 11, 'छ', 'chha', 'छाता', 'chhata'),
(44, 11, 'ज', 'ja', 'जग', 'jug'),
(45, 11, 'झ', 'jha', 'झंडा', 'jhanda'),
(46, 11, 'ट', 'ta', 'टमाटर', 'tamatar'),
(47, 11, 'ठ', 'tha', 'ठग', 'thag'),
(48, 11, 'ड', 'da', 'डमरू', 'damru'),
(49, 11, 'ढ', 'dha', 'ढोल', 'dhol'),
(50, 11, 'त', 'ta', 'तार', 'taar'),
(51, 11, 'थ', 'tha', 'थाली', 'thali'),
(52, 11, 'द', 'da', 'दरवाज़ा', 'darwaza'),
(53, 11, 'ध', 'dha', 'धनुष', 'dhanush'),
(54, 11, 'न', 'na', 'नल', 'nal'),
(55, 11, 'प', 'pa', 'पतंग', 'patang'),
(56, 11, 'फ', 'pha', 'फल', 'phal'),
(57, 11, 'ब', 'ba', 'बंदर', 'bandar'),
(58, 11, 'भ', 'bha', 'भालू', 'bhaloo'),
(59, 11, 'म', 'ma', 'मकड़ी', 'makdi'),
(60, 11, 'य', 'ya', 'यज्ञ', 'yagya'),
(61, 11, 'र', 'ra', 'रस्सी', 'rassi'),
(62, 11, 'ल', 'la', 'लकड़ी', 'lakdi'),
(63, 11, 'व', 'va', 'वजह', 'vajah'),
(64, 11, 'श', 'sha', 'शंख', 'shankh'),
(65, 11, 'ष', 'sha', 'षड्यंत्र', 'shadyantra'),
(66, 11, 'स', 'sa', 'सपेरा', 'sapera'),
(67, 11, 'ह', 'ha', 'हल', 'hal'),
(68, 11, 'क्ष', 'ksha', 'क्षत्रिय', 'kshatriya'),
(69, 11, 'त्र', 'tra', 'त्रिशूल', 'trishool'),
(70, 11, 'ज्ञ', 'gya', 'ज्ञान', 'gyaan'),
(71, 12, 'नमस्ते', 'namaste', 'हैलो!', 'hello!'),
(72, 12, 'आपका नाम क्या है?', 'aapka naam kya hai?', 'मेरा नाम _____ है।', 'mera naam _____ hai.'),
(73, 12, 'कैसे हो?', 'kaise ho?', 'मैं ठीक हूँ, धन्यवाद!', 'main theek hoon, dhanyavaad!'),
(74, 12, 'अलविदा', 'alvida', 'फिर मिलेंगे! / बाय!', 'phir milenge! / bye!'),
(75, 12, 'आप कहाँ से हैं?', 'aap kahaan se hain?', 'मैं भारत से हूँ।', 'main bhaarat se hoon.'),
(76, 13, 'एक', 'ek', 'यह संख्या एक है।', 'yah sankhya ek hai.'),
(77, 13, 'दो', 'do', 'मेरे पास दो पेन हैं।', 'mere paas do pen hain.'),
(78, 13, 'तीन', 'teen', 'उसके पास तीन किताबें हैं।', 'uske paas teen kitaaben hain.'),
(79, 13, 'चार', 'chaar', 'चार सेब हैं।', 'chaar seb hain.'),
(80, 13, 'पाँच', 'paanch', 'मुझे पाँच मिनट दो।', 'mujhe paanch minute do.'),
(81, 52, 'অ', 'aw', 'অমিতা (Amita)', 'aw-mee-taa'),
(82, 52, 'ক', 'ka', 'Ka (ক)', 'kaa'),
(83, 53, 'নমস্কার (Namaskar)', 'namaskar', 'Hello', 'hello'),
(84, 53, 'আপোনার নাম কি? (Apunar naam ki?)', 'apunar naam ki?', 'What is your name?', 'wot iz yor neym'),
(85, 54, 'এটা (Eta)', 'eta', 'One', 'wan'),
(86, 54, '5', 'paach', 'Odd number', 'odd num-bar'),
(87, 31, 'અ', 'A', 'અ માટે અંબા (Mango)', 'a maate amba'),
(88, 31, 'આ', 'Aa', 'આ માટે આઈસક્રીમ (Ice Cream)', 'aa maate aaiskreem'),
(89, 31, 'ઇ', 'I', 'ઇ માટે ઇન્ક (Ink)', 'i maate ink'),
(90, 31, 'ઈ', 'Ee', 'ઈ માટે ઈગલ (Eagle)', 'ee maate eegal'),
(91, 31, 'ઉ', 'U', 'ઉ માટે ઉંટ (Camel)', 'u maate unt'),
(92, 31, 'ઊ', 'Oo', 'ઊ માટે ઊંઘ (Sleep)', 'oo maate oongh'),
(93, 32, 'નમસ્તે', 'Namaste', 'હાય! તમે કેમ છો?', 'haay! tame kem cho?'),
(94, 32, 'તમારું નામ શું છે?', 'Tamaru naam shu che?', 'મારું નામ _____ છે.', 'maarun naam _____ che.'),
(95, 32, 'હું સારું છું.', 'Hu saru chu.', 'આભાર!', 'aabhar!'),
(96, 32, 'આ જમવાનો સમય છે.', 'Aa jamvano samay che.', 'ચાલો ખાઈએ.', 'chalo khaiye.'),
(97, 33, 'એક', 'Ek', 'મારે એક સાદો પેન્સિલ જોઈએ.', 'mare ek sado pencil joie.'),
(98, 33, 'બે', 'Be', 'મારે બે પુસ્તકો છે.', 'mare be pustako che.'),
(99, 33, 'ત્રણ', 'Tran', 'તેના પાસે ત્રણ બટાકા છે.', 'tena pase tran bataka che.'),
(100, 33, 'ચાર', 'Char', 'મારે ચાર કપડાં ધોવા છે.', 'mare char kapda dhova che.'),
(101, 33, 'પાંચ', 'Paanch', 'તે પાંચ વર્ષનો છે.', 'te paanch varsh no che.'),
(102, 21, 'അ', 'a', 'അമ്മ', 'amma'),
(103, 21, 'ക', 'ka', 'കുളി', 'kuli'),
(104, 22, 'നമസ്കാരം', 'namaskaram', 'Greetings', 'greetings'),
(105, 22, 'സുഖമാണോ?', 'sukhamaano?', 'Are you well?', 'are you well'),
(106, 23, 'ഒന്ന്', 'onnu', 'One', 'one'),
(107, 23, 'രണ്ട്', 'randu', 'Two', 'two'),
(108, 23, 'മൂന്ന്', 'moonnu', 'Three', 'three'),
(109, 24, 'നാമപദം', 'naamapadam', 'Noun', 'noun'),
(110, 24, 'ക്രിയാപദം', 'kriyaapadam', 'Verb', 'verb'),
(111, 45, 'నమస్కారం(namaskaram)', '', 'Hello', ''),
(112, 45, 'శుభోదయం', '', 'Good morning', ''),
(113, 45, 'శుభ సాయంత్రం', '', 'Good evening', ''),
(114, 45, 'ధన్యవాదాలు', '', 'Thank you', ''),
(115, 45, 'మీరు ఎలా ఉన్నారు?', '', 'How are you?', ''),
(116, 46, 'అవును', '', 'Yes', ''),
(117, 46, 'కాదు', '', 'No', ''),
(118, 46, 'దయచేసి', '', 'Please', ''),
(119, 46, 'క్షమించండి', '', 'Sorry', ''),
(120, 46, 'సరే', '', 'Okay', ''),
(121, 47, 'ఒకటి', '', 'One', ''),
(122, 47, 'రెండు', '', 'Two', ''),
(123, 47, 'మూడు', '', 'Three', ''),
(124, 47, 'నాలుగు', '', 'Four', ''),
(125, 47, 'ఐదు', '', 'Five', ''),
(126, 48, 'ఇంటి', '', 'House', ''),
(127, 48, 'నీరు', '', 'Water', ''),
(128, 48, 'అన్నం', '', 'Rice', ''),
(129, 48, 'పుస్తకం', '', 'Book', ''),
(130, 48, 'కుర్చీ', '', 'Chair', ''),
(131, 49, 'నాన్న', '', 'Father', ''),
(132, 49, 'అమ్మ', '', 'Mother', ''),
(133, 49, 'అన్న', '', 'Elder brother', ''),
(134, 49, 'చెల్లి', '', 'Younger sister', ''),
(135, 49, 'తమ్ముడు', '', 'Younger brother', ''),
(136, 50, 'తెలుపు', '', 'White', ''),
(137, 50, 'నలుపు', '', 'Black', ''),
(138, 50, 'ఎరుపు', '', 'Red', ''),
(139, 50, 'పచ్చ', '', 'Green', ''),
(140, 50, 'నీలం', '', 'Blue', ''),
(141, 51, 'సోమవారం', '', 'Monday', ''),
(142, 51, 'మంగళవారం', '', 'Tuesday', ''),
(143, 51, 'బుధవారం', '', 'Wednesday', ''),
(144, 51, 'గురువారం', '', 'Thursday', ''),
(145, 51, 'శుక్రవారం', '', 'Friday', '');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_scores`
--

CREATE TABLE `lesson_scores` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `lesson_title` varchar(255) DEFAULT NULL,
  `total_questions` int(11) DEFAULT NULL,
  `correct_answers` int(11) DEFAULT NULL,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lesson_scores`
--

INSERT INTO `lesson_scores` (`id`, `user_id`, `lesson_title`, `total_questions`, `correct_answers`, `completed_at`) VALUES
(1, 2, 'അക്ഷരമാല പഠിക്കുക (Learn the Alphabet)', 2, 2, '2025-07-20 16:06:06'),
(2, 2, 'എണ്ണങ്ങളും എണ്ണല്‍ (Numbers and Counting)', 2, 2, '2025-07-21 12:45:32'),
(3, 2, 'ഗ്രാമർ അടിസ്ഥാനങ്ങൾ (Basic Grammar Rules)', 2, 2, '2025-07-21 13:38:24'),
(4, 2, 'എണ്ണങ്ങളും എണ്ണല്‍ (Numbers and Counting)', 2, 2, '2025-07-21 13:38:30'),
(5, 2, 'ആശംസകളും പരിചയങ്ങളും (Greetings and Introductions)', 2, 2, '2025-07-21 13:38:45'),
(6, 2, 'ആശംസകളും പരിചയങ്ങളും (Greetings and Introductions)', 2, 2, '2025-07-21 14:22:05'),
(7, 2, 'અક્ષરમાળા શીખો (Learn the Alphabet)', 2, 2, '2025-07-24 16:10:25');

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`id`, `name`, `username`, `email`, `password`, `last_login`, `profile_pic`) VALUES
(1, 'ghanishta mishra', 'ghanishta', 'ghanishta@craft.com', '$2y$10$Dfjp679/yorvE0jvyPuhdeFOEDjI1PuQnzMxophXNJo1C1RFfU6OO', '2025-07-20 00:21:08', NULL),
(2, 'ghanu', 'shy', 'shy@mail.com', '$2y$10$cf14YbbBwUH5DtFYNup0VuNUDblIaeVIV6lTZMmg7gjmruUc1E0Kq', '2025-08-11 12:04:32', 'cat.png.jpg'),
(3, 'gg', 'hh', 'gg@gmail.com', '$2y$10$lW6Z222pvw0t8Wbkn4wXaOkNIOW6d9tZQjzgsj/QQLpfRKDc1aAkS', NULL, NULL),
(4, 'jay', 'jay', 'jay@867', '$2y$10$lY6by4T/FKPfkfhG2OawqOpWGS/RNMMnLYTNOYisiNVkQjRRGdzQG', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_courses`
--

CREATE TABLE `user_courses` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `progress` int(11) DEFAULT 0,
  `started_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_courses`
--

INSERT INTO `user_courses` (`id`, `course_id`, `course_name`, `progress`, `started_at`) VALUES
(1, 2, 'English Basics', 0, '2025-07-23 09:02:57');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `completed_lessons`
--
ALTER TABLE `completed_lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lesson_flashcards`
--
ALTER TABLE `lesson_flashcards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `lesson_scores`
--
ALTER TABLE `lesson_scores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_courses`
--
ALTER TABLE `user_courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `completed_lessons`
--
ALTER TABLE `completed_lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `lesson_flashcards`
--
ALTER TABLE `lesson_flashcards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `lesson_scores`
--
ALTER TABLE `lesson_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `signup`
--
ALTER TABLE `signup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_courses`
--
ALTER TABLE `user_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lesson_flashcards`
--
ALTER TABLE `lesson_flashcards`
  ADD CONSTRAINT `lesson_flashcards_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`);

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
