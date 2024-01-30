CREATE TABLE [dbo].[Users] (
    [email]    VARCHAR (40) NOT NULL,
    [F_name]   VARCHAR (20) NULL,
    [L_name]   VARCHAR (30) NULL,
    [password] VARCHAR (30) NOT NULL,
    PRIMARY KEY CLUSTERED ([email] ASC)
);

