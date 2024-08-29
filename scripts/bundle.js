const fs = require("fs");
const path = require("path");
const archiver = require("archiver");

const pluginSlug = "modula-best-grid-gallery";
const pluginFolder = "modula-best-grid-gallery";
const version = require("../package.json").version;

const output = fs.createWriteStream(
  path.join(__dirname, `../${pluginFolder}-${version}.zip`)
);
const archive = archiver("zip", {
  zlib: { level: 9 }
});

output.on("close", function () {
  console.log(archive.pointer() + " total bytes");
  console.log(
    "Archive has been finalized and the output file descriptor has closed."
  );
});
archive.on("error", function (err) {
  throw err;
});

archive.pipe(output);

archive.directory("build/includes/", `${pluginFolder}/includes`);
archive.directory("build/assets/", `${pluginFolder}/assets`);
archive.file("build/Modula.php", { name: `${pluginFolder}/Modula.php` });
archive.file("build/readme.txt", { name: `${pluginFolder}/readme.md` });
archive.file("build/changelog.txt", { name: `${pluginFolder}/changelog.txt` });
archive.file("build/license.txt", { name: `${pluginFolder}/license.txt` });
archive.file("build/readme.txt", { name: `${pluginFolder}/readme.txt` });
archive.file("build/SECURITY.md", { name: `${pluginFolder}/SECURITY.md` });

archive.finalize();
