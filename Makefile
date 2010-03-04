.PHONY: dump

ALL: dump

dump: 
	mysqldump multibindadmin > dump.sql