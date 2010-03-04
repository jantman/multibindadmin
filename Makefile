.PHONY: dump commit clean

ALL: dump

dump: 
	mysqldump --no-data multibindadmin > dump.sql

commit: clean
	svn commit

clean:
	-rm *~
	-rm bin/*~
	-rm config/*~
	-rm css/*~
	-rm handlers/*~
	-rm inc/*~
