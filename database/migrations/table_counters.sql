CREATE TABLE counters_y2017w04 (
    CHECK ( created_at >= DATE '2017-01-23' AND created_at < DATE '2017-01-30' )
) INHERITS (counters);
CREATE TABLE counters_y2017w05 (
    CHECK ( created_at >= DATE '2017-01-30' AND created_at < DATE '2017-02-06' )
) INHERITS (counters);
CREATE TABLE counters_y2017w06 (
    CHECK ( created_at >= DATE '2017-02-06' AND created_at < DATE '2017-02-13' )
) INHERITS (counters);
CREATE TABLE counters_y2017w07 (
    CHECK ( created_at >= DATE '2017-02-13' AND created_at < DATE '2017-02-20' )
) INHERITS (counters);
CREATE TABLE counters_y2017w08 (
    CHECK ( created_at >= DATE '2017-02-20' AND created_at < DATE '2017-02-27' )
) INHERITS (counters);


CREATE INDEX counters_y2017w04_item_id ON counters_y2017w04 USING btree(item_id);
CREATE INDEX counters_y2017w04_created_at ON counters_y2017w04 USING btree(created_at);

CREATE INDEX counters_y2017w05_item_id ON counters_y2017w05 USING btree(item_id);
CREATE INDEX counters_y2017w05_created_at ON counters_y2017w05 USING btree(created_at);

CREATE INDEX counters_y2017w06_item_id ON counters_y2017w06 USING btree(item_id);
CREATE INDEX counters_y2017w06_created_at ON counters_y2017w06 USING btree(created_at);

CREATE INDEX counters_y2017w07_item_id ON counters_y2017w07 USING btree(item_id);
CREATE INDEX counters_y2017w07_created_at ON counters_y2017w07 USING btree(created_at);

CREATE INDEX counters_y2017w08_item_id ON counters_y2017w08 USING btree(item_id);
CREATE INDEX counters_y2017w08_created_at ON counters_y2017w08 USING btree(created_at);


# After creating the function, we create a trigger which calls the trigger function:
CREATE TRIGGER insert_counters_trigger
    BEFORE INSERT ON counters
    FOR EACH ROW EXECUTE PROCEDURE counters_insert_trigger();


# We must redefine the trigger function each month so that it always points to the current partition.
# The trigger definition does not need to be updated, however.
#
# We want our application to be able to say INSERT INTO measurement ... and have the data be redirected
# into the appropriate partition table. We can arrange that by attaching a suitable trigger function to
# the master table. If data will be added only to the latest partition, we can use a very simple trigger function:
# 
# We might want to insert data and have the server automatically locate the partition into which the row
# should be added. We could do this with a more complex trigger function, for example:
CREATE OR REPLACE FUNCTION counters_insert_trigger()
RETURNS TRIGGER AS $$
BEGIN
    IF ( NEW.created_at >= DATE '2017-02-20' AND NEW.created_at < DATE '2017-02-27' ) THEN
        INSERT INTO counters_y2017w08 VALUES (NEW.*);
    ELSIF ( NEW.created_at >= DATE '2017-02-13' AND NEW.created_at < DATE '2017-02-20' ) THEN
        INSERT INTO counters_y2017w07 VALUES (NEW.*);
    ELSIF ( NEW.created_at >= DATE '2017-02-06' AND NEW.created_at < DATE '2017-02-13' ) THEN
        INSERT INTO counters_y2017w06 VALUES (NEW.*);
    ELSIF ( NEW.created_at >= DATE '2017-01-30' AND NEW.created_at < DATE '2017-02-06' ) THEN
        INSERT INTO counters_y2017w05 VALUES (NEW.*);
    ELSIF ( NEW.created_at >= DATE '2017-01-23' AND NEW.created_at < DATE '2017-01-30' ) THEN
        INSERT INTO counters_y2017w04 VALUES (NEW.*);
    ELSE
        RAISE EXCEPTION 'Date out of range. Fix the counters_insert_trigger() function!';
    END IF;
    RETURN NULL;
END;
$$
LANGUAGE plpgsql;
