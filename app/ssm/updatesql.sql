UPDATE appinfo
SET
    bank_account_holder_name = 'FALCON  ELECTRONICS',
    bank_name = 'UCO',
    bank_branch = 'Bhowanipore',
    bank_ac_no = '00310200011038',
    bank_ifsc = 'UCBA0000031',
	bank_qr = 'feqr.png'
WHERE name = 'Falcon Electronics';

UPDATE appinfo
SET
    bank_account_holder_name = 'FALCON',
    bank_name = 'UCO',
    bank_branch = 'Bhowanipore',
    bank_ac_no = '00310200011053',
    bank_ifsc = 'UCBA0000031',
	bank_qr = 'flqr.png'
WHERE name = 'Falcon';


INSERT INTO nextval (`type`,head,sno) VALUES
	 ('igfls','FLCN/23-24/S','1'),  -- Falcaon
     ('pays','FLCN/23-24/V','1'),
	 ('igfes','FLE/23-24/S','1'), -- Falcaon electronic id 1
     ('igflp','FLCN/23-24/P','1'), -- Falcaon
	 ('igfep','FLE/23-24/P','1'); -- Falcaon electronic
INSERT INTO secuence (id,`type`,head,sno,remarks,status) VALUES

	 (10,'igfls','FLCN/23-24/S','0',NULL,1),
	 (11,'igfes','FLE/23-24/S','0',NULL,1),
     (12,'pays','FLCN/23-24/V','0',NULL,1),
     (13,'igflp','FLCN/23-24/P','0',NULL,1),
	 (14,'igfep','FLE/23-24/P','0',NULL,1);


INSERT INTO nextval (`type`,head,sno) VALUES
	 ('ingfls','FLCN/23-24/S','1'),  -- Falcaon
	 ('ingfes','FLE/23-24/S','1'), -- Falcaon electronic id 1
     ('ingflp','FLCN/23-24/P','1'), -- Falcaon
	 ('ingfep','FLE/23-24/P','1'); -- Falcaon electronic

INSERT INTO secuence (id,`type`,head,sno,remarks,status) VALUES

	 (15,'ingfes','FLE/23-24/S','0',NULL,1),
     (16,'ingflp','FLCN/23-24/P','0',NULL,1),
	 (17,'ingfep','FLE/23-24/P','0',NULL,1),
		 (18,'ingfls','FLCN/23-24/S','0',NULL,1)
;

update client SET state = 'West Bengal';
