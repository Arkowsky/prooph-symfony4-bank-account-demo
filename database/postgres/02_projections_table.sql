CREATE TABLE projections (
  no BIGSERIAL,
  name VARCHAR(150) NOT NULL,
  position JSONB,
  state JSONB,
  status VARCHAR(28) NOT NULL,
  locked_until CHAR(26),
  PRIMARY KEY (no),
  UNIQUE (name)
);
CREATE TABLE event_streams (
  no BIGSERIAL,
  real_stream_name VARCHAR(150) NOT NULL,
  stream_name CHAR(41) NOT NULL,
  metadata JSONB,category VARCHAR(150),
  PRIMARY KEY (no),
  UNIQUE (stream_name)
);
CREATE INDEX on event_streams (category);
