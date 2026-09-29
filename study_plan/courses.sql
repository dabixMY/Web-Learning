

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `study_plan`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `course_id` int NOT NULL,
  `course_code` varchar(10) DEFAULT NULL,
  `course_name` varchar(100) DEFAULT NULL,
  `course_description` text,
  PRIMARY KEY (`course_id`)
) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_code`, `course_name`, `course_description`) VALUES
(1, 'UECS2194', 'Web Application Development', 'Introduction to basic web development concepts'),
(2, 'UECS1104', 'Programming and Problem Solving\r\n', 'Introduction to the basic structure of a computer system, types of programming languages, the\r\nprogramming process, and problem-solving concepts.'),
(3, 'UECS2333', 'Human-Computer Interaction Design', 'The study of how human, as a user, interact with the hardware and software components of a computer.'),
(4, 'UECM1024', 'Calculus I', 'Introduces basic calculus concepts and methods which are of fundamental importance to the study of continuous\r\nmathematical models in probability theory, statistics and engineering models.'),
(5, 'UECM1314', 'Fundamentals of Linear Algebra', 'Introduction to the most basic concepts in linear algebra. The topics to be discussed in this unit are vectors, matrices, determinants, eigenvalues and eigenvectors,\r\nvector spaces, linear transformations and orthogonality.\r\n');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
