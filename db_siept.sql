/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.4.13-MariaDB : Database - db_siept
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `tb_acara` */

DROP TABLE IF EXISTS `tb_acara`;

CREATE TABLE `tb_acara` (
  `id_acara` int(11) NOT NULL AUTO_INCREMENT,
  `text` text DEFAULT NULL,
  `tanggal_buat` datetime DEFAULT NULL,
  PRIMARY KEY (`id_acara`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_acara` */

insert  into `tb_acara`(`id_acara`,`text`,`tanggal_buat`) values (2,'Sidang Pertama','2021-03-18 08:15:50'),(4,'Sidang Lanjutan','2021-05-04 00:14:51');

/*Table structure for table `tb_dasar` */

DROP TABLE IF EXISTS `tb_dasar`;

CREATE TABLE `tb_dasar` (
  `id_dasar` int(11) NOT NULL AUTO_INCREMENT,
  `text` text DEFAULT NULL,
  `tanggal_buat` datetime DEFAULT NULL,
  PRIMARY KEY (`id_dasar`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_dasar` */

insert  into `tb_dasar`(`id_dasar`,`text`,`tanggal_buat`) values (3,'Penetapan Hari Sidang','2021-03-18 07:31:54'),(4,'Tindak Lanjut Perkara','2021-05-09 11:11:59');

/*Table structure for table `tb_guna` */

DROP TABLE IF EXISTS `tb_guna`;

CREATE TABLE `tb_guna` (
  `id_guna` int(11) NOT NULL AUTO_INCREMENT,
  `text` text DEFAULT NULL,
  `tanggal_buat` datetime DEFAULT NULL,
  PRIMARY KEY (`id_guna`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_guna` */

insert  into `tb_guna`(`id_guna`,`text`,`tanggal_buat`) values (2,'Pemeriksaan Sidang Pertama','2021-03-18 07:30:42'),(3,'Pemeriksaan Sidang Lanjutan','2021-03-18 07:30:59');

/*Table structure for table `tb_kode_permohonan` */

DROP TABLE IF EXISTS `tb_kode_permohonan`;

CREATE TABLE `tb_kode_permohonan` (
  `id_kode_permohonan` int(11) NOT NULL AUTO_INCREMENT,
  `kode_perkara` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_kode_permohonan`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_kode_permohonan` */

insert  into `tb_kode_permohonan`(`id_kode_permohonan`,`kode_perkara`) values (1,'Pdt.P');

/*Table structure for table `tb_no_surat_terakhir` */

DROP TABLE IF EXISTS `tb_no_surat_terakhir`;

CREATE TABLE `tb_no_surat_terakhir` (
  `id_no_surat_terakhir` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_terakhir` varchar(255) DEFAULT NULL,
  `status` enum('ya','tidak') DEFAULT NULL,
  PRIMARY KEY (`id_no_surat_terakhir`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_no_surat_terakhir` */

insert  into `tb_no_surat_terakhir`(`id_no_surat_terakhir`,`nomor_terakhir`,`status`) values (1,'31','tidak');

/*Table structure for table `tb_perihal` */

DROP TABLE IF EXISTS `tb_perihal`;

CREATE TABLE `tb_perihal` (
  `id_perihal` int(11) NOT NULL AUTO_INCREMENT,
  `text` text DEFAULT NULL,
  `tanggal_buat` datetime DEFAULT NULL,
  PRIMARY KEY (`id_perihal`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_perihal` */

insert  into `tb_perihal`(`id_perihal`,`text`,`tanggal_buat`) values (5,'Pemanggilan Sidang Elektronik','2021-03-18 07:31:25'),(6,'Pemanggilan Sidang','2021-03-19 08:19:57');

/*Table structure for table `tb_status` */

DROP TABLE IF EXISTS `tb_status`;

CREATE TABLE `tb_status` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `nama_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_status` */

insert  into `tb_status`(`id_status`,`nama_status`) values (1,'SPT dibuat perdata'),(2,'diteruskan ke panitera'),(3,'tidak disetujui panitera'),(4,'disetujui panitera'),(5,'diteruskan pp ke perdata'),(6,'selesai');

/*Table structure for table `tb_surat` */

DROP TABLE IF EXISTS `tb_surat`;

CREATE TABLE `tb_surat` (
  `id_surat` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_surat_full` varchar(255) DEFAULT NULL,
  `id_perkara` int(11) DEFAULT NULL,
  `nomor_perkara` varchar(255) DEFAULT NULL,
  `id_jurusita` int(11) DEFAULT NULL,
  `perihal` text DEFAULT NULL,
  `urutan_nomor_surat` int(11) DEFAULT NULL,
  `bulan_nomor_surat` varchar(2) DEFAULT NULL,
  `tahun_nomor_surat` varchar(4) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `id_pihak_penerima` int(11) DEFAULT NULL,
  `tanggal_buat` datetime DEFAULT NULL,
  `pembuat` varchar(255) DEFAULT NULL,
  `dasar` text DEFAULT NULL,
  `qrcode` varchar(255) DEFAULT NULL,
  `id_perihal` int(11) DEFAULT NULL,
  `id_dasar` int(11) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `id_guna` int(11) DEFAULT NULL,
  `hari` date DEFAULT NULL,
  `pukul` varchar(255) DEFAULT NULL,
  `id_acara` varchar(255) DEFAULT NULL,
  `id_pp` int(11) DEFAULT NULL,
  `jenis_surat_acc` enum('sama dengan sistem','custom') DEFAULT NULL,
  `file_custome` varchar(255) DEFAULT NULL,
  `tanggal_relaas` date DEFAULT NULL,
  `tanggal_teruskan_panitera` date DEFAULT NULL,
  `file_relaas` varchar(255) DEFAULT NULL,
  `tanggal_selesai` datetime DEFAULT NULL,
  PRIMARY KEY (`id_surat`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_surat` */

insert  into `tb_surat`(`id_surat`,`nomor_surat_full`,`id_perkara`,`nomor_perkara`,`id_jurusita`,`perihal`,`urutan_nomor_surat`,`bulan_nomor_surat`,`tahun_nomor_surat`,`tanggal_surat`,`id_pihak_penerima`,`tanggal_buat`,`pembuat`,`dasar`,`qrcode`,`id_perihal`,`id_dasar`,`id_status`,`id_guna`,`hari`,`pukul`,`id_acara`,`id_pp`,`jenis_surat_acc`,`file_custome`,`tanggal_relaas`,`tanggal_teruskan_panitera`,`file_relaas`,`tanggal_selesai`) values (1,'W15.U8/1/SPT/HK.02/4/2021',24208,'7/Pdt.G/2020/PN Rta',1,NULL,1,'4','2021','2021-04-20',27935,'2021-04-20 07:11:30','perdata',NULL,'20210420071130.png',5,3,4,2,'2021-04-29','09:00','2',6,NULL,NULL,NULL,NULL,NULL,NULL),(2,'W15.U8/2/SPT/HK.02/5/2021',24208,'7/Pdt.G/2020/PN Rta',1,NULL,2,'5','2021','2021-05-04',27935,'2021-05-03 23:50:14','perdata',NULL,'20210503235014.png',5,3,4,2,'2021-05-20','09:00','2',6,NULL,NULL,NULL,NULL,NULL,NULL),(4,'W15.U8/4/SPT/HK.02/5/2021',25093,'2/Pdt.G/2021/PN Rta',2,NULL,4,'5','2021','2021-05-04',28999,'2021-05-03 23:57:43','perdata',NULL,'20210503235743.png',5,3,6,3,'2021-05-04','09:00','2',6,NULL,NULL,'2021-05-10',NULL,'20210509103934.pdf','2021-05-09 10:39:34'),(5,'W15.U8/5/SPT/HK.02/5/2021',25093,'2/Pdt.G/2021/PN Rta',2,NULL,5,'5','2021','2021-05-09',28998,'2021-05-09 08:53:10','perdata',NULL,'20210509085310.png',6,3,6,2,'2021-05-11','09:00','2',6,'custom','20210509100216.rtf','2021-05-10','2021-05-09','20210509104036.pdf','2021-05-09 10:40:36'),(7,'W15.U8/6/SPT/HK.02/5/2021',28,'1/PDT.G/2013/PN.RTA',2,'5',6,'5','2021','2021-05-09',1,'2021-05-09 10:56:59','suryaharryp','3','20210509105658.png',5,3,1,2,'2021-05-11','09:00','2',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,'W15.U8/7/SPT/HK.02/5/2021',30,'3/PDT.G/2013/PN.RTU',2,'5',7,'5','2021','2021-05-10',411,'2021-05-09 10:59:45','suryaharryp','3','20210509105945.png',5,3,1,2,'2021-05-25','09:00','2',NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `tb_surat_status` */

DROP TABLE IF EXISTS `tb_surat_status`;

CREATE TABLE `tb_surat_status` (
  `id_surat_status` int(11) NOT NULL AUTO_INCREMENT,
  `id_surat` int(11) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `tanggal_buat` datetime DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_surat_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_surat_status` */

/*Table structure for table `tb_user` */

DROP TABLE IF EXISTS `tb_user`;

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `nama_user` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `level` enum('panitera','perdata','admin','pp','jurusita') DEFAULT NULL,
  `id_sipp320` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_user` */

insert  into `tb_user`(`id_user`,`username`,`nama_user`,`password`,`level`,`id_sipp320`) values (1,'vendetta','Okta Pilopa','123456','admin',NULL),(2,'mansyah','Mansyah, S.H','123456','panitera',NULL),(4,'perdata','Jullak Damang','123456','perdata',NULL),(5,'suryaharryp','Surya Harry Prayoga','123456','admin',NULL),(6,'pp','Ahrarudin','123456','pp',NULL),(7,'hjatun','HJ.RABIATUN HASANAH','123456','jurusita',1),(8,'hjyuli','H. AHMAD YULIANSYAH','123456','jurusita',2);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
