.PHONY: dump

ALL: dump

dump: 
	mysqldump --no-data multibindadmin > dump.sql