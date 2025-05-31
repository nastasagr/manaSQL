function dbLogin() {
  return {
    host: "",
    user: "",
    pass: "",
    database: "",
    loggedIn: false,
    session: {},
    errorMessage: "",
    loading: true,
    timeoutRef: null,
    tables: [],

    // connect to database
    async connect() {
      try {
        const res = await fetch("requests.php?method=connect", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            host: this.host,
            user: this.user,
            pass: this.pass,
            database: this.database,
          }),
        });

        const data = await res.json();

        if (!res.ok || !data.success) {
          this.showMessage(data.message || "Σφάλμα σύνδεσης.");
          return;
        }

        this.loggedIn = true;
        this.session = data.session;

        this.loadTables();
      } catch (err) {
        this.showMessage("Αδυναμία σύνδεσης.");
      }
    },

    // fetch current DB tables
    async loadTables() {
      try {
        const res = await fetch("requests.php?method=tables");
        const data = await res.json();

        if (!data.success) {
          this.showMessage(data.message || "Αποτυχία φόρτωσης πινάκων.");
          return;
        }

        this.tables = data.tables;
      } catch (err) {
        this.showMessage("Σφάλμα κατά την ανάκτηση πινάκων.");
      }
    },

    showMessage(msg) {
      this.errorMessage = msg;

      if (this.timeoutRef) {
        clearTimeout(this.timeoutRef);
      }

      this.timeoutRef = setTimeout(() => {
        this.errorMessage = "";
        this.timeoutRef = null;
      }, 3000);
    },

    // destroy session data

    async logout() {
      const res = await fetch("requests.php?method=logout", {
        method: "POST",
      });
      const data = await res.json();
      if (data.success) {
        this.loggedIn = false;
        this.session = {};
        this.tables = [];
      }
    },

    // validate user session
    async checkSession() {
      try {
        const res = await fetch("requests.php?method=sessionCheck");
        const data = await res.json();
        if (data.loggedIn) {
          this.loggedIn = true;
          this.session = data.session;
          this.loadTables();
        }
      } catch (e) {
      } finally {
        this.loading = false;
      }
    },

    async dropDatabase() {
      const res = await fetch("requests.php?method=dropDatabase", {
        method: "POST",
      });
      const data = await res.json();
      if (data.success) {
        this.loggedIn = false;
        this.session = {};
        this.tables = [];
        this.showMessage(data.message);
      }
    },
  };
}
