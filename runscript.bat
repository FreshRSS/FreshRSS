@echo Script started
@echo === (Rename files) =============================================================
ren package.json package2.json
ren package-windows.json package.json
@echo === (Start script 1 of 3) ======================================================
call npm run eslint
@echo === (Start script 2 of 3) ======================================================
call npm run stylelint
@echo === (Start script 3 of 3) ======================================================
call phpcbf -p -s .
@echo === (Scripts DONE) =============================================================
ren package.json package-windows.json
ren package2.json package.json
@echo === (Files renamed back. FINISH) ===============================================