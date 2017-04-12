# 1. Inserto los contadores del vendor y tecnologia a su tambla temporal.
# 2. Los copio a su tabla correspondiente eliminando duplicados.
# 3. Vacio la tabla temporale.
# ----------------------------------------------------------------------------------------------------------------
# ERI - 2G - HORA
echo "Processing ERI-2G, $(date +%T) -------------------->"
sudo -u postgres psql rtm -c "\COPY eri.tmp_2g FROM 'bulk_2g_eri_hour.csv' delimiter ';' csv;"
sudo -u postgres psql rtm -c 'INSERT INTO eri.counters_2g_hour SELECT * FROM eri.tmp_2g ON CONFLICT DO NOTHING;'
sudo -u postgres psql rtm -c 'TRUNCATE eri.tmp_2g;'
# ERI - 3G - ROP
echo "Processing ERI-3G, $(date +%T) -------------------->"
sudo -u postgres psql rtm -c "\COPY eri.tmp_3g FROM 'bulk_3g_eri_rop.csv' delimiter ';' csv;"
sudo -u postgres psql rtm -c 'INSERT INTO eri.counters_3g_rop SELECT * FROM eri.tmp_3g ON CONFLICT DO NOTHING;'
sudo -u postgres psql rtm -c 'TRUNCATE eri.tmp_3g;'
# ERI - 3G - ROP
echo "Processing ERI-4G, $(date +%T) -------------------->"
sudo -u postgres psql rtm -c "\COPY eri.tmp_4g FROM 'bulk_4g_eri_rop.csv' delimiter ';' csv;"
sudo -u postgres psql rtm -c 'INSERT INTO eri.counters_4g_rop SELECT * FROM eri.tmp_4g ON CONFLICT DO NOTHING;'
sudo -u postgres psql rtm -c 'TRUNCATE eri.tmp_4g;'
# HUA - 2G - HORA
echo "Processing HUA-2G, $(date +%T) -------------------->"
sudo -u postgres psql rtm -c "\COPY hua.tmp_2g FROM 'bulk_2g_hua_hour.csv' delimiter ';' csv;"
sudo -u postgres psql rtm -c 'INSERT INTO hua.counters_2g_hour SELECT * FROM hua.tmp_2g ON CONFLICT DO NOTHING;'
sudo -u postgres psql rtm -c 'TRUNCATE hua.tmp_2g;'
# HUA - 3G - ROP
echo "Processing HUA-3G, $(date +%T) -------------------->"
sudo -u postgres psql rtm -c "\COPY hua.tmp_3g FROM 'bulk_3g_hua_rop.csv' delimiter ';' csv;"
sudo -u postgres psql rtm -c 'INSERT INTO hua.counters_3g_rop SELECT * FROM hua.tmp_3g ON CONFLICT DO NOTHING;'
sudo -u postgres psql rtm -c 'TRUNCATE hua.tmp_3g;'
# HUA - 3G - ROP
echo "Processing HUA-4G, $(date +%T) -------------------->"
sudo -u postgres psql rtm -c "\COPY hua.tmp_4g FROM 'bulk_4g_hua_rop.csv' delimiter ';' csv;"
sudo -u postgres psql rtm -c 'INSERT INTO hua.counters_4g_rop SELECT * FROM hua.tmp_4g ON CONFLICT DO NOTHING;'
sudo -u postgres psql rtm -c 'TRUNCATE hua.tmp_4g;'