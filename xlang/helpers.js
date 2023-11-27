const fs = require("fs")
const {exec} = require('child_process')
const http = require('http')
const extract = require('extract-zip')

// Download file
exports.downloadFile = async (url, dest, cb) => {
  return new Promise((resolve, reject) => {
    let file = fs.createWriteStream(dest);
    let request = http.get(url, function (response) {
      response.pipe(file);
      file.on('finish', function () {
        file.close();

        resolve();
      });
    });
  });
}

// Unzip file
exports.unzipFile = async (source, target) => {
  return new Promise((resolve, reject) => {
    extract(source, {dir: target}, function (err) {
      resolve()
    })
  });
}

// Read file content
exports.readFile = async (path) => {
  return new Promise((resolve, reject) => {
    fs.readFile(path, 'utf8', function (err, data) {
      if (err) {
        reject(err);
      }
      resolve(data);
    });
  });
}

// Read directory content
exports.readdir = async (path) => {
  return new Promise((resolve, reject) => {
    fs.readdir(path, 'utf8', function (err, data) {
      if (err) {
        reject(err);
      }
      resolve(data);
    });
  });
}

// Execute commands
exports.exec = async (cmd) => {
  return new Promise((resolve, reject) => {
    exec(cmd, (error, stdout, stderr) => {
      if (error) {
        console.warn(error);
      }
      resolve(stdout ? stdout : stderr);
    });
  });
}

// Match all
exports.matchAll = (regexPattern, sourceString) => {
  let output = []
  let match
  // make sure the pattern has the global flag
  let regexPatternWithGlobal = RegExp(regexPattern, "g")
  while (match = regexPatternWithGlobal.exec(sourceString)) {
    // get rid of the string copy
    delete match.input
    // store the match data
    output.push(match)
  }
  return output
}

// Capitalize first letter
exports.ucFirst = (string) => {
  return string.charAt(0).toUpperCase() + string.slice(1);
}
