# Database configuration

FreshRSS supports the databases SQLite (built-in), PostgreSQL, MariaDB / MySQL.

While the default installation should be fine for most cases, additional tuning can be made.

## Full-text search optimisation in PostgreSQL

Without changing anything in FreshRSS’ code (which is using [`ILIKE`](https://www.postgresql.org/docs/current/functions-matching.html#FUNCTIONS-LIKE)), it is possible to make text searches much faster by adding some indexes in PostgreSQL 9.1+ (at the cost of more disc space and slower insertions):

```sql
CREATE EXTENSION pg_trgm;
CREATE INDEX gin_trgm_index_title ON freshrss_entry USING gin(title gin_trgm_ops);
CREATE INDEX gin_trgm_index_content ON freshrss_entry USING gin(content gin_trgm_ops);
CREATE STATISTICS freshrss_entry_stats ON title, content FROM freshrss_entry;
ANALYZE freshrss_entry;
```

Where `freshrss_entry` needs to be adapted to the name of the *entry* of a given use, e.g., `freshrss_alice_entry`.

Such an index on the `entry.title` column makes searches such as `intitle:Hello` much faster.
General searches such as `Something` search both on `entry.title` and `entry.content` and therefore require the two indexes shown above.

Likewise, if you wanted to speed up searches on the authors (`author:Alice`), you would add another index:

```sql
CREATE INDEX gin_trgm_index_author ON freshrss_entry USING gin(author gin_trgm_ops);
```

Etc. for other text fields. The list of fields can be seen in [`CREATE TABLE _entry` section](https://github.com/FreshRSS/FreshRSS/blob/edge/app/SQL/install.sql.pgsql.php).

### References

* [GIN: Generalized Inverted Index](https://www.postgresql.org/docs/current/gin-intro.html)
* [`pg_trgm` module for fast text search](https://www.postgresql.org/docs/current/pgtrgm.html#id-1.11.7.42.8)
