-- MySQL dump 10.19  Distrib 10.3.28-MariaDB, for Linux (aarch64)
--
-- Host: localhost    Database: tarot
-- ------------------------------------------------------
-- Server version	10.3.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cards`
--

DROP TABLE IF EXISTS `cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card` varchar(32) NOT NULL,
  `upright` varchar(160) NOT NULL,
  `reversed` varchar(128) NOT NULL,
  `upurl` varchar(128) NOT NULL,
  `revurl` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cards`
--

LOCK TABLES `cards` WRITE;
/*!40000 ALTER TABLE `cards` DISABLE KEYS */;
INSERT INTO `cards` VALUES (1,'The World Card','completion, achievement, fulfilment, sense of belonging, wholeness, harmony','lack of closure, lack of achievement, feeling incomplete, emptiness','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-world-meaning-major-arcana-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-world-meaning-major-arcana-tarot-card-meanings#rev'),(2,'The Judgement Card','self-evaluation, awakening, renewal, purpose, reflection, reckoning','self-doubt, lack of self-awareness, failure to learn lessons, self-loathing','https://labyrinthos.co/blogs/tarot-card-meanings-list/judgement-meaning-major-arcana-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/judgement-meaning-major-arcana-tarot-card-meanings#rev'),(3,'The Sun Card','happiness, success, optimism, vitality, joy, confidence, happiness, truth','blocked happiness, excessive enthusiasm, pessimism, unrealistic expectations, conceitedness','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-sun-meaning-major-arcana-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-sun-meaning-major-arcana-tarot-card-meanings#rev'),(4,'The Moon Card','illusion, intuition, uncertainty, confusion, complexity, secrets, unconscious','fear, deception, anxiety, misunderstanding, misinterpretation, clarity, understanding','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-moon-meaning-major-arcana-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-moon-meaning-major-arcana-tarot-card-meanings#rev'),(5,'The Star Card','hope, inspiration, positivity, faith, renewal, healing, rejuvenation','hopelessness, despair, negativity, lack of faith, despondent','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-star-meaning-major-arcana-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-star-meaning-major-arcana-tarot-card-meanings#rev'),(6,'The Tower Card','disaster, destruction, upheaval, trauma, sudden change, chaos','averting disaster, delaying the inevitable, resisting change','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-tower-meaning-major-arcana-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-tower-meaning-major-arcana-tarot-card-meanings#rev'),(7,'The Devil Card','oppression, addiction, obsession, dependency, excess, powerlessness, limitations','independence, freedom, revelation, release, reclaiming power, reclaiming control','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-devil-meaning-major-arcana-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-devil-meaning-major-arcana-tarot-card-meanings#rev'),(8,'The Temperance Card','balance, peace, patience, moderation, calm, tranquillity, harmony, serenity','imbalance, excess, extremes, discord, recklessness, hastiness','https://labyrinthos.co/blogs/tarot-card-meanings-list/temperance-meaning-major-arcana-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/temperance-meaning-major-arcana-tarot-card-meanings#rev'),(9,'The Death Card','transformation, endings, change, transition, letting go, release','fear of change, repeating negative patterns, resisting change, stagnancy, decay','https://labyrinthos.co/blogs/tarot-card-meanings-list/death-meaning-major-arcana-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/death-meaning-major-arcana-tarot-card-meanings#rev'),(10,'The Hanged Man Card','sacrifice, waiting, uncertainty, lack of direction, perspective, contemplation','stalling, disinterest, stagnation, avoiding sacrifice, standstill, apathy','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-hanged-man-meaning-major-arcana-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-hanged-man-meaning-major-arcana-tarot-card-meanings#rev'),(11,'The Justice Card','justice, karma, consequence, accountability, law, truth, honesty, integrity, cause and effect','injustice, retribution, dishonesty, corruption, dishonesty, unfairness, avoiding accountability','https://labyrinthos.co/blogs/tarot-card-meanings-list/justice-meaning-major-arcana-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/justice-meaning-major-arcana-tarot-card-meanings#rev'),(12,'The Wheel of Fortune Card','change, cycles, fate, decisive moments, luck, fortune, unexpected events','bad luck, lack of control, clinging to control, unwelcome changes, delays','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-wheel-of-fortune-meaning-major-arcana-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-wheel-of-fortune-meaning-major-arcana-tarot-card-meanings#rev'),(13,'The Hermit Card','self-reflection, introspection, contemplation, withdrawal, solitude, search for self','loneliness, isolation, recluse, being anti-social, rejection, returning to society','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-hermit-meaning-major-arcana-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-hermit-meaning-major-arcana-tarot-card-meanings#rev'),(14,'The Strength Card','courage, bravery, confidence, compassion, self-confidence, inner power','self-doubt, weakness, low confidence, inadequacy, cowardice, forcefulness','https://labyrinthos.co/blogs/tarot-card-meanings-list/strength-meaning-major-arcana-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/strength-meaning-major-arcana-tarot-card-meanings#rev'),(15,'The Chariot Card','success, ambition, determination, willpower, control, self-discipline, focus','forceful, no direction, no control, powerless, aggression, obstacles','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-chariot-meaning-major-arcana-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-chariot-meaning-major-arcana-tarot-card-meanings#rev'),(16,'The Lovers Card','love, unions, partnerships, relationships, choices, romance, balance, unity','disharmony, imbalance, conflict, detachment, bad choices, indecision','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-lovers-meaning-major-arcana-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-lovers-meaning-major-arcana-tarot-card-meanings#rev'),(17,'The Hierophant Card','tradition, social groups, conventionality, conformity, education, knowledge, beliefs','rebellion, unconventionality, non-conformity, new methods, ignorance','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-hierophant-meaning-major-arcana-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-hierophant-meaning-major-arcana-tarot-card-meanings#rev'),(18,'The Emperor Card','stability, structure, protection, authority, control, practicality, focus, discipline','tyrant, domineering, rigid, stubborn, lack of discipline, recklessness','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-emperor-meaning-major-arcana-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-emperor-meaning-major-arcana-tarot-card-meanings#rev'),(19,'The Empress Card','divine feminine, sensuality, fertility, nurturing, creativity, beauty, abundance, nature','insecurity, overbearing, negligence, smothering, lack of growth, lack of progress','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-empress-meaning-major-arcana-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-empress-meaning-major-arcana-tarot-card-meanings#rev'),(20,'The High Priestess Card','unconscious, intuition, mystery, spirituality, higher power, inner voice','repressed intuition, hidden motives, superficiality, confusion, cognitive dissonance','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-high-priestess-meaning-major-arcana-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-high-priestess-meaning-major-arcana-tarot-card-meanings#rev'),(21,'The Magician Card','willpower, desire, being resourceful, skill, ability, concentration, manifestation','manipulation, cunning, trickery, wasted talent, illusion, deception','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-magician-meaning-major-arcana-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-magician-meaning-major-arcana-tarot-card-meanings#rev'),(22,'The Fool Card','beginnings, freedom, innocence, originality, adventure, idealism, spontaneity','reckless, careless, distracted, naive, foolish, gullible, stale, dull','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-fool-meaning-major-arcana-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/the-fool-meaning-major-arcana-tarot-card-meanings#rev'),(23,'The Seven of Wands','protectiveness, standing up for yourself, defending yourself, protecting territory','giving up, admitting defeat, yielding, lack of self belief, surrender','https://labyrinthos.co/blogs/tarot-card-meanings-list/seven-of-wands-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/seven-of-wands-meaning-tarot-card-meanings#rev'),(24,'The Four of Wands','community, home, celebrations, reunions, parties, gatherings, stability, belonging','lack of support, instability, feeling unwelcome, transience, lack of roots, home conflict','https://labyrinthos.co/blogs/tarot-card-meanings-list/four-of-wands-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/four-of-wands-meaning-tarot-card-meanings#rev'),(25,'The Ace of Wands','inspiration, creative spark, new initiative, new passion, enthusiasm, energy','delays, blocks, lack of passion, lack of energy, hesitancy, creative blocks','https://labyrinthos.co/blogs/tarot-card-meanings-list/ace-of-wands-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/ace-of-wands-meaning-tarot-card-meanings#rev'),(26,'The Ten of Wands','burden, responsibility, duty, stress, obligation, burning out, struggles','failure to delegate, shouldering too much responsibility, collapse, breakdown','https://labyrinthos.co/blogs/tarot-card-meanings-list/ten-of-wands-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/ten-of-wands-meaning-tarot-card-meanings#rev'),(27,'The Nine of Wands','last stand, persistence, grit, resilience, perseverance, close to success, fatigue','stubbornness, rigidity, defensiveness, refusing compromise, giving up','https://labyrinthos.co/blogs/tarot-card-meanings-list/nine-of-wands-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/nine-of-wands-meaning-tarot-card-meanings#rev'),(28,'The Eight of Wands','movement, speed, progress, quick decisions, sudden changes, excitement','waiting, slowness, chaos, delays, losing momentum, hastiness, being unprepared','https://labyrinthos.co/blogs/tarot-card-meanings-list/eight-of-wands-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/eight-of-wands-meaning-tarot-card-meanings#rev'),(29,'The Six of Wands','success, victory, triumph, rewards, recognition, praise, acclaim, pride','failure, lack of recognition, no rewards, lack of achievement','https://labyrinthos.co/blogs/tarot-card-meanings-list/six-of-wands-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/six-of-wands-meaning-tarot-card-meanings#rev'),(30,'The Five of Wands','conflict, competition, arguments, aggression, tension, rivals, clashes of ego','end of conflict, cooperation, agreements, truces, harmony, peace, avoiding conflict','https://labyrinthos.co/blogs/tarot-card-meanings-list/five-of-wands-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/five-of-wands-meaning-tarot-card-meanings#rev'),(31,'The Three of Wands','momentum, confidence, expansion, growth, foresight, looking ahead','restriction, limitations, lack of progress, obstacles, delays, frustration','https://labyrinthos.co/blogs/tarot-card-meanings-list/three-of-wands-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/three-of-wands-meaning-tarot-card-meanings#rev'),(32,'The Two of Wands','planning, first steps, making decisions, leaving comfort, taking risks','bad planning, overanalyzing, not taking action, playing it safe, avoiding risk','https://labyrinthos.co/blogs/tarot-card-meanings-list/two-of-wands-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/two-of-wands-meaning-tarot-card-meanings#rev'),(33,'The Page of Wands','adventure, excitement, fresh ideas, cheerfulness, energetic, fearless, extroverted','hasty, impatient, lacking ideas, tantrums, laziness, boring, unreliable, distracted','https://labyrinthos.co/blogs/tarot-card-meanings-list/page-of-wands-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/page-of-wands-meaning-tarot-card-meanings#rev'),(34,'The Queen of Wands','confident, self-assured, passionate, determined, social, charismatic, vivacious, optimistic','demanding, vengeful, low confidence, jealous, selfish, temperamental, bully','https://labyrinthos.co/blogs/tarot-card-meanings-list/queen-of-wands-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/queen-of-wands-meaning-tarot-card-meanings#rev'),(35,'The King of Wands','leadership, vision, big picture, taking control, daring decisions, boldness, optimism','forceful, domineering, tyrant, vicious, powerless, ineffective, weak leader','https://labyrinthos.co/blogs/tarot-card-meanings-list/king-of-wands-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/king-of-wands-meaning-tarot-card-meanings#rev'),(36,'The Knight of Wands','courageous, energetic, charming, hero, rebellious, hot-tempered, free spirit','arrogant, reckless, impatient, lack of self-control, passive, volatile, domineering','https://labyrinthos.co/blogs/tarot-card-meanings-list/knight-of-wands-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/knight-of-wands-meaning-tarot-card-meanings#rev'),(37,'The King of Cups','wise, diplomatic, balance between head and heart, devoted, advisor, counselor','overwhelmed, anxious, cold, repressed, withdrawn, manipulative, selfish','https://labyrinthos.co/blogs/tarot-card-meanings-list/king-of-cups-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/king-of-cups-meaning-tarot-card-meanings#rev'),(38,'The Queen of Cups','compassion, warmth, kindness, intuition, healer, counselor, supportive','insecurity, giving too much, overly sensitive, needy, fragile, dependence, martyrdom','https://labyrinthos.co/blogs/tarot-card-meanings-list/queen-of-cups-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/queen-of-cups-meaning-tarot-card-meanings#rev'),(39,'The Knight of Cups','idealist, charming, artistic, graceful, tactful, diplomatic, mediator, negotiator','disappointment, tantrums, moodiness, turmoil, avoiding conflict, vanity','https://labyrinthos.co/blogs/tarot-card-meanings-list/knight-of-cups-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/knight-of-cups-meaning-tarot-card-meanings#rev'),(40,'The Page of Cups','idealism, sensitivity, dreamer, naivete, innocence, inner child, head in the clouds','emotional vulnerability, immaturity, neglecting inner child, escapism, insecurity','https://labyrinthos.co/blogs/tarot-card-meanings-list/page-of-cups-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/page-of-cups-meaning-tarot-card-meanings#rev'),(41,'The Ten of Cups','happiness, homecomings, fulfillment, emotional stability, security, domestic harmony','unhappy home, separation, domestic conflict, disharmony, isolation','https://labyrinthos.co/blogs/tarot-card-meanings-list/ten-of-cups-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/ten-of-cups-meaning-tarot-card-meanings#rev'),(42,'The Nine of Cups','wishes coming true, contentment, satisfaction, success, achievements, recognition, pleasure','unhappiness, lack of fulfillment, disappointment, underachievement, arrogance, snobbery','https://labyrinthos.co/blogs/tarot-card-meanings-list/nine-of-cups-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/nine-of-cups-meaning-tarot-card-meanings#rev'),(43,'The Eight of Cups','abandonment, walking away, letting go, searching for truth, leaving behind','stagnation, monotony, accepting less, avoidance, fear of change, staying in bad situation','https://labyrinthos.co/blogs/tarot-card-meanings-list/eight-of-cups-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/eight-of-cups-meaning-tarot-card-meanings#rev'),(44,'The Seven of Cups','choices, searching for purpose, illusion, fantasy, daydreaming, wishful thinking, indecision','lack of purpose, disarray, confusion, diversion, distractions, clarity, making choices','https://labyrinthos.co/blogs/tarot-card-meanings-list/seven-of-cups-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/seven-of-cups-meaning-tarot-card-meanings#rev'),(45,'The Six of Cups','nostalgia, memories, familiarity, healing, comfort, sentimentality, pleasure','stuck in past, moving forward, leaving home, independence','https://labyrinthos.co/blogs/tarot-card-meanings-list/six-of-cups-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/six-of-cups-meaning-tarot-card-meanings#rev'),(46,'The Five of Cups','loss, grief, disappointment, sadness, mourning, discontent, feeling let down','acceptance, moving on, finding peace, contentment, seeing positives','https://labyrinthos.co/blogs/tarot-card-meanings-list/five-of-cups-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/five-of-cups-meaning-tarot-card-meanings#rev'),(47,'The Four of Cups','apathy, contemplation, feeling disconnected, melancholy, boredom, indifference, discontent','clarity, awareness, acceptance, choosing happiness, depression, negativity','https://labyrinthos.co/blogs/tarot-card-meanings-list/four-of-cups-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/four-of-cups-meaning-tarot-card-meanings#rev'),(48,'The Three of Cups','friendship, community, gatherings, celebrations, group events, social events','gossip, scandal, excess, isolation, loneliness, solitude, imbalanced social life','https://labyrinthos.co/blogs/tarot-card-meanings-list/three-of-cups-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/three-of-cups-meaning-tarot-card-meanings#rev'),(49,'The Two of Cups','unity, partnership, attraction, connection, close bonds, joining forces, mutual respect','separation, rejection, division, imbalance, tension, bad communication, withdrawal','https://labyrinthos.co/blogs/tarot-card-meanings-list/two-of-cups-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/two-of-cups-meaning-tarot-card-meanings#rev'),(50,'The Ace of Cups','love, new feelings, emotional awakening, creativity, spirituality, intuition','coldness, emptiness, emotional loss, blocked creativity, feeling unloved, gloominess','https://labyrinthos.co/blogs/tarot-card-meanings-list/ace-of-cups-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/ace-of-cups-meaning-tarot-card-meanings#rev'),(51,'The King of Swords','reason, authority, discipline, integrity, morality, seriousness, high standards, strict','irrational, dictator, oppressive, inhumane, controlling, cold, ruthless, dishonest','https://labyrinthos.co/blogs/tarot-card-meanings-list/king-of-swords-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/king-of-swords-meaning-tarot-card-meanings#rev'),(52,'The Knight of Swords','assertive, direct, impatient, intellectual, daring, focused, perfectionist, ambitious','rude, tactless, forceful, bully, aggressive, vicious, ruthless, arrogant','https://labyrinthos.co/blogs/tarot-card-meanings-list/knight-of-swords-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/knight-of-swords-meaning-tarot-card-meanings#rev'),(53,'The Queen of Swords','honest, independent, principled, fair, constructive criticism, objective, perceptive','pessimistic, malicious, manipulative, harsh, bitter, spiteful, cruel, deceitful, unforgiving','https://labyrinthos.co/blogs/tarot-card-meanings-list/queen-of-swords-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/queen-of-swords-meaning-tarot-card-meanings#rev'),(54,'The Page of Swords','curious, witty, chatty, communicative, inspired, vigilant, alert, mental agility','scatterbrained, cynical, sarcastic, gossipy, insulting, rude, lack of planning','https://labyrinthos.co/blogs/tarot-card-meanings-list/page-of-swords-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/page-of-swords-meaning-tarot-card-meanings#rev'),(55,'The Ten of Swords','ruin, failure, bitterness, collapse, exhaustion, dead-end, victimization, betrayal','survival, improvement, healing, lessons learned, despair, relapse','https://labyrinthos.co/blogs/tarot-card-meanings-list/ten-of-swords-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/ten-of-swords-meaning-tarot-card-meanings#rev'),(56,'The Nine of Swords','fear, anxiety, negativity, breaking point, despair, nightmares, isolation','recovery, learning to cope, facing life, finding help, shame, guilt, mental health issues','https://labyrinthos.co/blogs/tarot-card-meanings-list/nine-of-swords-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/nine-of-swords-meaning-tarot-card-meanings#rev'),(57,'The Eight of Swords','trapped, restricted, victimized, paralyzed, helpless, powerless, imprisonment','freedom, release, taking control, survivor, facing fears, empowered, surrender','https://labyrinthos.co/blogs/tarot-card-meanings-list/eight-of-swords-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/eight-of-swords-meaning-tarot-card-meanings#rev'),(58,'The Seven of Swords','lies, trickery, scheming, strategy, resourcefulness, sneakiness, cunning','confession, conscience, regret, maliciousness, truth revealed','https://labyrinthos.co/blogs/tarot-card-meanings-list/seven-of-swords-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/seven-of-swords-meaning-tarot-card-meanings#rev'),(59,'The Six of Swords','moving on, departure, leaving behind, distance, accepting lessons','stuck in past, returning to trouble, running away from problems, trapped','https://labyrinthos.co/blogs/tarot-card-meanings-list/six-of-swords-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/six-of-swords-meaning-tarot-card-meanings#rev'),(60,'The Five of Swords','arguments, disputes, aggression, bullying, intimidation, conflict, hostility, stress','reconciliation, resolution, compromise, revenge, regret, remorse, cutting losses','https://labyrinthos.co/blogs/tarot-card-meanings-list/five-of-swords-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/five-of-swords-meaning-tarot-card-meanings#rev'),(61,'The Four of Swords','rest, relaxation, peace, sanctuary, recuperation, self-protection, rejuvenation','recovery, awakening, re-entering the world, release from isolation, restlessness, burnout','https://labyrinthos.co/blogs/tarot-card-meanings-list/four-of-swords-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/four-of-swords-meaning-tarot-card-meanings#rev'),(62,'The Three of Swords','heartbreak, separation, sadness, grief, sorrow, upset, loss, trauma, tears','healing, forgiveness, recovery, reconciliation, repressing emotions','https://labyrinthos.co/blogs/tarot-card-meanings-list/three-of-swords-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/three-of-swords-meaning-tarot-card-meanings#rev'),(63,'The Ace of Swords','clarity, breakthrough, new idea, concentration, vision, force, focus, truth','confusion, miscommunication, hostility, arguments, destruction, brutality','https://labyrinthos.co/blogs/tarot-card-meanings-list/ace-of-swords-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/ace-of-swords-meaning-tarot-card-meanings#rev'),(64,'The King of Pentacles','abundance, prosperity, security, ambitious, safe, kind, patriarchal, protective, businessman, provider, sensual, reliable','greed, materialistic, wasteful, chauvinist, poor financial decisions, gambler, exploitative, possessive','https://labyrinthos.co/blogs/tarot-card-meanings-list/king-of-pentacles-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/king-of-pentacles-meaning-tarot-card-meanings#rev'),(65,'The Queen of Pentacles','generous, caring, nurturing, homebody, good business sense, practical, comforting, welcoming, sensible, luxurious','selfish, unkempt, jealous, insecure, greedy, materialistic, gold digger, intolerant, self-absorbed, envious','https://labyrinthos.co/blogs/tarot-card-meanings-list/queen-of-pentacles-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/queen-of-pentacles-meaning-tarot-card-meanings#rev'),(66,'The Knight of Pentacles','practical, reliable, efficient, stoic, slow and steady, hard-working, committed, patient, conservative','workaholic, laziness, dull, boring, no initiative, cheap, irresponsible, gambler, risky investments','https://labyrinthos.co/blogs/tarot-card-meanings-list/knight-of-pentacles-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/knight-of-pentacles-meaning-tarot-card-meanings#rev'),(67,'The Page of Pentacles','ambitious, diligent, goal-oriented, planner, consistent, star student, studious, grounded, loyal, faithful, dependable','foolish, immature, irresponsible, lazy, underachiever, procrastinator, missed chances, poor prospects','https://labyrinthos.co/blogs/tarot-card-meanings-list/page-of-pentacles-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/page-of-pentacles-meaning-tarot-card-meanings#rev'),(68,'The Ten of Pentacles','legacy, roots, family, ancestry, inheritance, windfall, foundations, privilege, affluence, stability, tradition','family disputes, bankruptcy, debt, fleeting success, conflict over money, instability, breaking traditions','https://labyrinthos.co/blogs/tarot-card-meanings-list/ten-of-pentacles-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/ten-of-pentacles-meaning-tarot-card-meanings#rev'),(69,'The Nine of Pentacles','rewarded efforts, success, achievement, independence, leisure, material security, self-sufficiency','being guarded, living beyond means, material instability, reckless spending, superficiality','https://labyrinthos.co/blogs/tarot-card-meanings-list/nine-of-pentacles-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/nine-of-pentacles-meaning-tarot-card-meanings#rev'),(70,'The Eight of Pentacles','skill, talent, craftsmanship, quality, high standards, expertise, mastery, commitment, dedication, accomplishment','lack of quality, rushed job, bad reputation, lack of motivation, mediocrity, laziness, low skill, dead-end job','https://labyrinthos.co/blogs/tarot-card-meanings-list/eight-of-pentacles-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/eight-of-pentacles-meaning-tarot-card-meanings#rev'),(71,'The Seven of Pentacles','harvest, rewards, results, growth, progress, perseverance, patience, planning','unfinished work, procrastination, low effort, waste, lack of growth, setbacks, impatience, lack of reward','https://labyrinthos.co/blogs/tarot-card-meanings-list/seven-of-pentacles-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/seven-of-pentacles-meaning-tarot-card-meanings#rev'),(72,'The Six of Pentacles','generosity, charity, community, material help, support, sharing, giving and receiving, gratitude','power dynamics, abuse of generosity, strings attached gifts, inequality, extortion','https://labyrinthos.co/blogs/tarot-card-meanings-list/six-of-pentacles-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/six-of-pentacles-meaning-tarot-card-meanings#rev'),(73,'The Five of Pentacles','hardship, loss, isolation, feeling abandoned, adversity, struggle, unemployment, alienation, disgrace','positive changes, recovery from loss, overcoming adversity, forgiveness, feeling welcomed','https://labyrinthos.co/blogs/tarot-card-meanings-list/five-of-pentacles-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/five-of-pentacles-meaning-tarot-card-meanings#rev'),(74,'The Four of Pentacles','possessiveness, insecurity, hoarding, stinginess, stability, security, savings, materialism, wealth, frugality, boundaries, guardedness','generosity, giving, spending, openness, financial insecurity, reckless spending','https://labyrinthos.co/blogs/tarot-card-meanings-list/four-of-pentacles-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/four-of-pentacles-meaning-tarot-card-meanings#rev'),(75,'The Three of Pentacles','teamwork, shared goals, collaboration, apprenticeship, effort, pooling energy','lack of cohesion, lack of teamwork, apathy, poor motivation, conflict, ego, competition','https://labyrinthos.co/blogs/tarot-card-meanings-list/three-of-pentacles-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/three-of-pentacles-meaning-tarot-card-meanings#rev'),(76,'The Two of Pentacles','balancing resources, adaptation, resourcefulness, flexibility, stretching resources','imbalance, unorganized, overwhelmed, messiness, chaos, overextending','https://labyrinthos.co/blogs/tarot-card-meanings-list/two-of-pentacles-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/two-of-pentacles-meaning-tarot-card-meanings#rev'),(77,'The Ace of Pentacles','new opportunities, resources, abundance, prosperity, security, stability, manifestation','missed chances, scarcity, deficiency, instability, stinginess, bad investments','https://labyrinthos.co/blogs/tarot-card-meanings-list/ace-of-pentacles-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/ace-of-pentacles-meaning-tarot-card-meanings#rev'),(78,'Two of Swords','stalemate, difficult choices, stuck in the middle, denial, hidden information','indecision, hesitancy, anxiety, too much information, no right choice, truth revealed','https://labyrinthos.co/blogs/tarot-card-meanings-list/two-of-swords-meaning-tarot-card-meanings#up','https://labyrinthos.co/blogs/tarot-card-meanings-list/two-of-swords-meaning-tarot-card-meanings#rev');
/*!40000 ALTER TABLE `cards` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-06-02  5:27:32
