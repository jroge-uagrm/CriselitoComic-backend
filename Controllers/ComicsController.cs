using CloudinaryDotNet;
using CloudinaryDotNet.Actions;
using criselitocomic_backend.Entities;
using criselitocomic_backend.Repositories;
using Microsoft.AspNetCore.Mvc;

namespace criselitocomic_backend.Controllers
{
    [ApiController]
    [Route("api/[controller]")]
    public class ComicsController : ControllerBase
    {
        private readonly ComicsRepository _comicsRepository;
        public ComicsController(ComicsRepository comicsRepository)
        {
            _comicsRepository = comicsRepository;
        }

        [HttpPost]
        public IActionResult Post([FromBody] Comic comic)
        {
            _comicsRepository.Insert(comic);
            return Ok(comic);
        }

        [HttpGet]
        public IActionResult GetAll()
        {
            return Ok(_comicsRepository.GetAll());
        }

        [HttpGet("{id}")]
        public IActionResult GetById(string id)
        {
            return Ok(_comicsRepository.GetById(id));
        }

        [HttpPut("{id}")]
        public IActionResult PutById(string id, [FromBody] Comic comic)
        {
            _comicsRepository.Update(id, comic);
            return Ok(comic);
        }

        [HttpDelete("{id}")]
        public IActionResult DeleteById(string id)
        {
            Comic comic = _comicsRepository.GetById(id);
            _comicsRepository.Delete(id);
            return Ok(comic);
        }

        [HttpPost("{id}/files")]
        public IActionResult UploadFile(string id, [FromForm] IFormFile file)
        {
            Comic comic = _comicsRepository.GetById(id);
            if(comic is null)
            {
                return NotFound();
            }
            comic.FilePath = _comicsRepository.UploadFile(file);
            _comicsRepository.Update(id, comic);
            return Ok(comic);
        }
    }
}