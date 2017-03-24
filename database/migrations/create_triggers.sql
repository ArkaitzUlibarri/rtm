CREATE TRIGGER insert_counters_2g_trigger
    BEFORE INSERT ON eri.counters_2g
    FOR EACH ROW EXECUTE PROCEDURE eri.counters_2g_trigger();

CREATE TRIGGER insert_counters_2g_hour_trigger
    BEFORE INSERT ON eri.counters_2g_hour
    FOR EACH ROW EXECUTE PROCEDURE eri.counters_2g_hour_trigger();

CREATE TRIGGER insert_counters_3g_trigger
    BEFORE INSERT ON eri.counters_3g
    FOR EACH ROW EXECUTE PROCEDURE eri.counters_3g_trigger();

CREATE TRIGGER insert_counters_3g_hour_trigger
    BEFORE INSERT ON eri.counters_3g_hour
    FOR EACH ROW EXECUTE PROCEDURE eri.counters_3g_hour_trigger();

CREATE TRIGGER insert_counters_4g_trigger
    BEFORE INSERT ON eri.counters_4g
    FOR EACH ROW EXECUTE PROCEDURE eri.counters_4g_trigger();

CREATE TRIGGER insert_counters_4g_hour_trigger
    BEFORE INSERT ON eri.counters_4g_hour
    FOR EACH ROW EXECUTE PROCEDURE eri.counters_4g_hour_trigger();



CREATE TRIGGER insert_counters_2g_trigger
    BEFORE INSERT ON hua.counters_2g
    FOR EACH ROW EXECUTE PROCEDURE hua.counters_2g_trigger();

CREATE TRIGGER insert_counters_2g_hour_trigger
    BEFORE INSERT ON hua.counters_2g_hour
    FOR EACH ROW EXECUTE PROCEDURE hua.counters_2g_hour_trigger();

CREATE TRIGGER insert_counters_3g_trigger
    BEFORE INSERT ON hua.counters_3g
    FOR EACH ROW EXECUTE PROCEDURE hua.counters_3g_trigger();

CREATE TRIGGER insert_counters_3g_hour_trigger
    BEFORE INSERT ON hua.counters_3g_hour
    FOR EACH ROW EXECUTE PROCEDURE hua.counters_3g_hour_trigger();

CREATE TRIGGER insert_counters_4g_trigger
    BEFORE INSERT ON hua.counters_4g
    FOR EACH ROW EXECUTE PROCEDURE hua.counters_4g_trigger();

CREATE TRIGGER insert_counters_4g_hour_trigger
    BEFORE INSERT ON hua.counters_4g_hour
    FOR EACH ROW EXECUTE PROCEDURE hua.counters_4g_hour_trigger();