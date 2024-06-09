ALTER TABLE `student_application_form` ADD `role` VARCHAR(25) NOT NULL AFTER `instructor_status`;
ALTER TABLE `user` ADD `base` VARCHAR(25) NOT NULL AFTER `password`;
UPDATE `user` SET `role` = '3';
UPDATE user SET role = '4' WHERE instructor_status != 1;
UPDATE user SET batch = (SELECT batch.batch FROM batch WHERE batch.id=user.batch);
UPDATE user SET status = 'ENABLE' WHERE instructor_status = 1;
ALTER TABLE `user` ADD `menu` TEXT NOT NULL AFTER `base`;
ALTER TABLE `authorize_approval` ADD `json_setting` TEXT NOT NULL AFTER `number`;
UPDATE user SET status = 'ACTIVE' WHERE status = 'ENABLE'
ALTER TABLE `daily_flight_schedule` ADD `tpm` VARCHAR(50) NOT NULL AFTER `batch`;


UPDATE daily_flight_schedule SET mission = (SELECT tpm_syllabus_all_course.subject_mission FROM tpm_syllabus_all_course WHERE tpm_syllabus_all_course.id = daily_flight_schedule.mission);
UPDATE daily_flight_schedule SET course = (SELECT course.course_code FROM course WHERE course.id = daily_flight_schedule.course);
UPDATE tpm_syllabus_all_course SET curriculum = (SELECT curriculum.code FROM curriculum WHERE curriculum.id = tpm_syllabus_all_course.curriculum);
UPDATE course SET curriculum = (SELECT curriculum.code FROM curriculum WHERE curriculum.id = course.curriculum);

UPDATE batch SET curriculum = (SELECT curriculum.code FROM curriculum WHERE curriculum.id = batch.curriculum);


UPDATE daily_flight_schedule SET aircraft_reg = (SELECT aircraft.aircraft_code FROM aircraft WHERE aircraft.id = daily_flight_schedule.aircraft_reg);

UPDATE daily_flight_schedule SET pic = (SELECT user.id_number FROM user WHERE user.id = daily_flight_schedule.pic);

UPDATE daily_flight_schedule SET 2nd = (SELECT user.id_number FROM user WHERE user.id = daily_flight_schedule.2nd);
UPDATE daily_flight_schedule SET duty_instructor = (SELECT user.id_number FROM user WHERE user.id = daily_flight_schedule.duty_instructor)
UPDATE daily_flight_schedule SET batch = (SELECT batch.batch FROM batch WHERE batch.id = daily_flight_schedule.batch);


UPDATE transaksi SET ekspedisi = (SELECT ekspedisi.kode FROM ekspedisi WHERE ekspedisi.id = transaksi.ekspedisi)

'instructor_status'=>'1'
"type LIKE '%GROUND%' OR type LIKE '%FTD%' OR type LIKE '%FLIGHT%'";


UPDATE tpm_syllabus_all_course SET course = (SELECT course.course_code FROM course WHERE course.id = tpm_syllabus_all_course.course);

ALTER TABLE `synthetic_training_devices_document` ADD `code` VARCHAR(25) NOT NULL AFTER `type_enginee`;

UPDATE synthetic_training_devices_document SET code = CONCAT(serial_number,'-',type_enginee);

LTER TABLE `daily_ftd_schedule` ADD `tpm` VARCHAR(35) NOT NULL AFTER `batch`;

